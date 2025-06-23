<?php

namespace App\Http\Controllers;

use App\Models\Band;
use App\Models\Live;
use App\Models\BandMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BandController extends Controller
{
    /**
     * バンド一覧を表示
     */
    public function index()
    {
        $bands = Band::with(['creator', 'live'])->get();
        return view('bands.index', compact('bands'));
    }

    /**
     * バンド登録フォームを表示
     */
    public function create($liveId = null)
    {
        $live = null;
        if ($liveId) {
            $live = Live::findOrFail($liveId);
        }

        return view('bands.create', compact('live'));
    }

    /**
     * 新しいバンドを保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'live_id' => 'required|exists:lives,id',
            'members' => 'required|array|min:1',
            'members.*.name' => 'required|string|max:255',
            'members.*.part' => 'required|string|max:255',
        ]);

        // メンバー名のバリデーション
        $invalidMembers = [];
        foreach ($request->members as $index => $member) {
            $user = User::where('name', $member['name'])->first();
            if (!$user) {
                $invalidMembers[] = $member['name'];
            }
        }

        if (!empty($invalidMembers)) {
            return back()
                ->withInput()
                ->withErrors([
                    'members' => '以下のメンバーは登録されていないユーザーです: ' . implode(', ', $invalidMembers)
                ]);
        }

        $band = new Band();
        $band->name = $request->name;
        $band->made_by = Auth::id();
        $band->live_id = $request->live_id;
        $band->save();

        // メンバー情報を保存
        foreach ($request->members as $memberData) {
            $user = User::where('name', $memberData['name'])->first();

            $bandMember = new BandMember();
            $bandMember->band_id = $band->id;
            $bandMember->member_id = $user->id;
            $bandMember->name = $memberData['name'];
            $bandMember->part = $memberData['part'];
            $bandMember->save();
        }

        return redirect()->route('bands.show', $band)
            ->with('success', 'バンドを登録しました。');
    }

    /**
     * バンドの詳細を表示
     */
    public function show($id)
    {
        $band = Band::with(['creator', 'live', 'members'])->findOrFail($id);
        return view('bands.show', compact('band'));
    }

    /**
     * バンドの編集フォームを表示
     */
    public function edit($id)
    {
        $band = Band::findOrFail($id);

        // バンドの作成者または管理者のみが編集可能
        if (Auth::id() != $band->made_by && !Auth::user()->admin) {
            return redirect()->route('bands.show', $band)
                ->with('error', '編集権限がありません。');
        }

        return view('bands.edit', compact('band'));
    }

    /**
     * バンドの情報を更新
     */
    public function update(Request $request, Band $band)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'live_id' => 'required|exists:lives,id',
            'members' => 'required|array|min:1',
            'members.*.name' => 'required|string|max:255',
            'members.*.part' => 'required|string|max:255',
        ]);

        // メンバー名のバリデーション
        $invalidMembers = [];
        foreach ($request->members as $index => $member) {
            $user = User::where('name', $member['name'])->first();
            if (!$user) {
                $invalidMembers[] = $member['name'];
            }
        }

        if (!empty($invalidMembers)) {
            return back()
                ->withInput()
                ->withErrors([
                    'members' => '以下のメンバーは登録されていないユーザーです: ' . implode(', ', $invalidMembers)
                ]);
        }

        $band->name = $request->name;
        $band->live_id = $request->live_id;
        $band->save();

        // 既存のメンバーを削除
        $band->members()->delete();

        // 新しいメンバー情報を保存
        foreach ($request->members as $memberData) {
            $user = User::where('name', $memberData['name'])->first();

            $bandMember = new BandMember();
            $bandMember->band_id = $band->id;
            $bandMember->member_id = $user->id;
            $bandMember->name = $memberData['name'];
            $bandMember->part = $memberData['part'];
            $bandMember->save();
        }

        return redirect()->route('bands.show', $band)
            ->with('success', 'バンドを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        // バンドの作成者または管理者のみが削除可能
        if ($band->made_by !== Auth::id() && !Auth::user()->is_admin) {
            return redirect()->route('bands.show', $band)
                ->with('error', __('このバンドを削除する権限がありません。'));
        }

        // バンドを削除（関連するメンバー情報も自動的に削除される）
        $band->delete();

        return redirect()->route('dashboard')
            ->with('success', __('バンドを削除しました。'));
    }

    /**
     * バンドからメンバーを削除
     */
    public function removeMember(Band $band, Request $request)
    {
        // 自分がメンバーであることを確認
        $member = BandMember::where('band_id', $band->id)
            ->where('name', Auth::user()->name)
            ->first();

        if (!$member) {
            return redirect()->route('bands.show', $band)
                ->with('error', __('このバンドのメンバーではありません。'));
        }

        // メンバーを削除
        $member->delete();

        return redirect()->route('dashboard')
            ->with('success', __('バンドから脱退しました。'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Live;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LiveController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // 認証チェックはルートで行う
    }

    /**
     * 管理者かどうかをチェック
     */
    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->admin) {
            return redirect()->route('dashboard')->with('error', '管理者権限が必要です。');
        }
        return null;
    }

    /**
     * ライブ一覧を表示
     */
    public function index()
    {
        $lives = Live::orderBy('held_date', 'desc')->get();
        return view('lives.index', compact('lives'));
    }

    /**
     * ライブ登録フォームを表示
     */
    public function create()
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) return $adminCheck;

        return view('lives.create');
    }

    /**
     * 新しいライブを保存
     */
    public function store(Request $request)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) return $adminCheck;

        $request->validate([
            'name' => 'required|string|max:255',
            'held_date' => 'required|date',
            'entry_due' => 'required|date|before:held_date',
        ]);

        Live::create($request->all());

        return redirect()->route('lives.index')
            ->with('success', 'ライブを登録しました。');
    }

    /**
     * ライブの詳細を表示
     */
    public function show($id)
    {
        $live = Live::findOrFail($id);
        return view('lives.show', compact('live'));
    }

    /**
     * ライブの編集フォームを表示
     */
    public function edit($id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) return $adminCheck;

        $live = Live::findOrFail($id);
        return view('lives.edit', compact('live'));
    }

    /**
     * ライブの情報を更新
     */
    public function update(Request $request, $id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) return $adminCheck;

        $live = Live::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'held_date' => 'required|date',
            'entry_due' => 'required|date|before:held_date',
        ]);

        $live->update($request->all());

        return redirect()->route('lives.index')
            ->with('success', 'ライブ情報を更新しました。');
    }

    /**
     * ライブを削除
     */
    public function destroy($id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) return $adminCheck;

        $live = Live::findOrFail($id);
        $live->delete();

        return redirect()->route('lives.index')
            ->with('success', 'ライブを削除しました。');
    }
}

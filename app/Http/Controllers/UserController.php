<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 幹部がUser情報を編集するためのコントローラ
     */
    //
    public function index()
    {

        if (Auth::user()->admin != 1) {
            return redirect('/');
        }

        $users = User::all();

        return view('profile.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if (Auth::user()->admin != 1) {
            return redirect('/');
        } elseif (Auth::user()->id == $user->id) {
            return redirect('/users');
        } else {
            // adminカラムをトグル（0なら1、1なら0に変更）
            $user->admin = $user->admin == 1 ? 0 : 1;
            $user->save();

            // 成功メッセージをセッションに保存してリダイレクト
            return redirect()->back()->with('status', '管理者を追加、削除しました');
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'ユーザーを削除しました。');
    }

    /**
     * ユーザー検索API
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::where('name', 'like', "%{$query}%")
            ->select('id', 'name')
            ->limit(5)
            ->get();

        return response()->json($users);
    }
}

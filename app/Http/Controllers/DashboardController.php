<?php

namespace App\Http\Controllers;

use App\Models\StudioReservation;
use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // ログインユーザーの予約を取得
        $myReservations = StudioReservation::where('user_id', $user->id)
            ->with('studio')
            ->orderBy('use_datetime', 'desc')
            ->get();

        // ユーザーが所属しているバンドを取得
        $bands = Band::whereHas('members', function($query) use ($user) {
            $query->where('name', $user->name);
        })->with(['creator', 'live'])->get();

        return view('dashboard', compact('myReservations', 'bands'));
    }
}

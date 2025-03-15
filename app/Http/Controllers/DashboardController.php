<?php

namespace App\Http\Controllers;

use App\Models\StudioReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // ログインユーザの予約情報を取得
        $myReservations = StudioReservation::where('reserved_user_id', Auth::id())->get();

        //バンド情報を取得
        // $myBands =

        // 取得したデータをビューに渡す
        return view('dashboard',["myReservations" => $myReservations ]);
    }
}

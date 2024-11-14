<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use app\Models\StudioReservation;
use Illuminate\Support\Facades\Auth;


class StudioReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $startOfWeek = $request->input('week_start') ? Carbon::parse($request->input('week_start')) : Carbon::now()->startOfWeek();
        
        return view('studio_reservations.create', compact('startOfWeek'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $reservations = $request->input('reservation');

        // 予約情報を保存
        foreach ($reservations as $hour => $days) {
            foreach ($days as $day => $value) {


                // 予約が選択されていれば保存
                if ($value) {


                    StudioReservation::create([
                        'datetime' => Carbon::parse($day . ' ' . $hour . ':00'),
                        'reserved_person' => Auth::user()->id,
                        'reserved_band' => 'バンド名',  // 必要に応じてバンド名やスタジオ名を取得
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('studio_reservation.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

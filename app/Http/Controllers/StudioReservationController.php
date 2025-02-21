<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\StudioReservation;
use App\Models\Studio;
use Illuminate\Support\Facades\Auth;


class StudioReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     * スタジオの予約状況のテーブルを表示する。
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * スタジオの予約表を表示する関数
     */
    public function create(Request $request)
    {
        // スタジオ一覧を取得
        $studios = Studio::all();

        // 現在選択されているスタジオID（デフォルトは最初のスタジオ）
        $currentStudioId = $request->input('studio_id', $studios->first()->id);

        // 表示開始日（デフォルトは現在の週の始まり）
        $startOfWeek = $request->input('week_start')
            ? Carbon::parse($request->input('week_start'))
            : Carbon::now()->startOfWeek();

        // 現在のスタジオの予約データを取得
        $reservations = StudioReservation::where('studio_id', $currentStudioId)
            ->whereBetween('use_datetime', [$startOfWeek, (clone $startOfWeek)->endOfWeek()->endOfDay()])
            ->with('reservedUser') // 予約者の情報を取得する
            ->get()
            ->groupBy(function ($reservation) {
            return $reservation->use_datetime->format('Y-m-d H:i');
    });

        // ビューにデータを渡す
        return view('studio-reservation', [
            'studios' => $studios,             // スタジオ一覧
            'currentStudioId' => $currentStudioId,  // 現在選択されているスタジオID
            'startOfWeek' => $startOfWeek,     // 表示開始日
            'reservations' => $reservations,   // 予約データ
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション（必須フィールドの確認）
        $request->validate([
            'studio_id' => 'required|exists:studios,id', // studiosテーブルのIDが有効か確認
            'reservation' => 'required|array',           // 予約データが配列であることを確認
        ]);

        $studioId = $request->input('studio_id'); // フォームから送信されたスタジオID
        $reservations = $request->input('reservation'); // 予約情報

        if (!$reservations) {
            return redirect()->back()->with('status', '予約が選択されていません。');
        }

        // 予約情報を保存
        foreach ($reservations as $hour => $days) {
            foreach ($days as $day => $value) {
                // 予約が選択されている場合に保存
                if ($value) {
                    StudioReservation::create([
                        'use_datetime' => Carbon::parse($day . ' ' . $hour . ':00'), // 予約日時
                        'studio_id' => $studioId,                                    // スタジオID
                        'reserved_user_id' => Auth::user()->id,                 // ログイン中のユーザーID
                        'reserved_band_id' => 0,                            // 固定値のバンド名
                    ]);
                }
            }
        }

        // 保存完了後のリダイレクト
        return redirect()->route('studio-reservations.create', ['studio_id' => $studioId])
            ->with('status', '予約が完了しました！');
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
        try{
            $reservation = StudioReservation::findOrFail($id);
            $reservation->delete();
            return redirect()->back()->with('status', 'キャンセルが完了しました！');
        }
        catch (\Exception $e) {
            // エラーメッセージをセッションに保存
            return redirect()->back()->with('status', 'キャンセルに失敗しました。');
        }
    }

}


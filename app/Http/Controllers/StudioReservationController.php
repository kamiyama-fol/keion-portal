<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\StudioReservation;
use App\Models\Studio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class StudioReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     * スタジオの予約状況のテーブルを表示する。
     */
    public function index(Request $request)
    {
        //
        $query = StudioReservation::withTrashed()->orderBy('use_datetime', 'desc');

        // 期間で絞り込み
        // 期間で絞り込み (タイムスタンプも含む)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
                    ->orWhereBetween('deleted_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
                    ->orWhereBetween('use_datetime', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            });
        }

        // 動作で絞り込み
        if ($request->filled('action')) {
            if ($request->action == 'reserved') {
                $query->whereNull('deleted_at');
            } elseif ($request->action == 'canceled') {
                $query->whereNotNull('deleted_at');
            }
        }

        // 予約者名で絞り込み
        if ($request->filled('reserved_user_name')) {
            $query->whereHas('reservedUser', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->reserved_user_name . '%');
            });
        }

        // 予約バンドで絞り込み
        if ($request->filled('reserved_band_id')) {
            $query->where('reserved_band_id', 'like', '%' . $request->reserved_band_id . '%');
        }


        $reservations = $query->get();

        if (auth()->user()->admin){
            return view('reservation-list', compact('reservations'));
        }else{
            return redirect()->back()->with('status', '権限がありません');
        }

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

        $existingReservation = StudioReservation::where('studio_id', $request->studio_id)
            ->where('use_datetime', $request->use_datetime)
            ->whereNull('deleted_at') // 論理削除されていないものだけチェック
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->with('status', 'その時間帯は既に予約されています。');
        }

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
                        'reserved_band_id' => '入力して下さい',                            // 固定値のバンド名
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
        $reservation = StudioReservation::with(['studio', 'reservedUser'])->findOrFail($id);


        return view('reservation-detail', [
            'reservation' => $reservation,
        ]);
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
        //一時的にstringに
        $validator = Validator::make($request->all(), [
            'reserved_band_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $reservation = StudioReservation::find($id);

        if (!$reservation) {
            abort(404, '予約が見つかりません');
        } elseif (auth()->check() && (auth()->user()->admin || $reservation->reserved_user_id == auth()->id())) {
            $reservation->reserved_band_id = $request->reserved_band_id;
            $reservation->save();

            return back()->with('status', 'バンド名を更新しました。');
        } else {
            return redirect()->back()->with('status', '更新する権限がありません。');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = StudioReservation::find($id);

        if (!$reservation) {
            return back()->with('status', '予約が見つかりません。');
        }

        // ログインしているか確認
        if (!auth()->check()) {
            return redirect('/login')->with('status', 'ログインしてください。');
        }

        // 管理者 または 予約者本人なら削除を許可
        if (auth()->user()->admin || $reservation->reserved_user_id == auth()->id()) {
            $reservation->delete();
            return redirect('/dashboard')->with('status', '予約を削除しました。');
        }

        return back()->with('status', 'キャンセルする権限がありません。');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StudioReservation;
use Carbon\Carbon;

class DeletePastReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:delete-past-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '過去のスタジオ予約を削除するコマンド';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 過去の予約を取得（論理削除されていないもの）
        $pastReservations = StudioReservation::where('use_datetime', '<', Carbon::now())
            ->whereNull('deleted_at');

        // 予約のデータ数が1000を超えたら物理削除（容量圧迫防止）
        if ($pastReservations->count() > 1000) {
            $deleted = $pastReservations->forceDelete();
            $this->info("過去の予約を {$deleted} 件物理削除しました。");
        } else {
            // 論理削除
            $deleted = $pastReservations->delete();
            $this->info("過去の予約を {$deleted} 件論理削除しました。");
        }
    }
}

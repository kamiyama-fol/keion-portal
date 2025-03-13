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
        //
        $pastReservation = StudioReservation::where('reserve_datetime', '<', Carbon::now());

        //予約のデータ数が1000を超えたら物理削除（容量圧迫防止）
        if ($pastReservation->count() > 10000){
            $deleted = $pastReservation->forceDelete();
        }else{
            //論理削除
            $deleted = $pastReservation->delete();
        }


        $this->info("過去の予約を {$deleted} 件削除しました。");
    }
}

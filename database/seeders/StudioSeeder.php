<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('studios')->insert([
            [
            'name' => '課外活動等2Fスタジオ',
            'made_user_id' => 1
        ],
        [
            'name' => '大教室スタジオ',
            'made_user_id' => 1
        ]]
        );
    }
}

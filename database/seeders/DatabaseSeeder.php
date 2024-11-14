<?php

namespace Database\Seeders;

use App\Models\Studio;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            [
                'name' => '上山航輝',
                'display_name' => 'カミヤマ',
                'grate' => 3,
                'admin' => 'true',
                'email' => 'g2220745@cc.kyoto-su.ac.jp',
                'password' => 'test12345'
            ]

        ]);

        Studio::factory()->create([
            [
                'name' => '大学スタジオ',
                'made_by' => '1'
            ]
        ]);
    }
}

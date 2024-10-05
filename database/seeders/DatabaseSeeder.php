<?php

namespace Database\Seeders;

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
                'admin' => 'true',
                'email' => 'g2220745@cc.kyoto-su.ac.jp',
                'password' => 'test12345'
            ]

        ]);
    }
}

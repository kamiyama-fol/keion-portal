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
                'family_name' => '上山',
                'first_name' => '航輝',
                'display_name' => 'kamiyama',
                'email' => 'g2220745@cc.kyoto-su.ac.jp'
            ]
        ]);
    }
}

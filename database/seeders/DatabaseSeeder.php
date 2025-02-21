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
        //

        User::updateOrCreate(
            ['id'=> 1],
            [
                'name' => '上山航輝',
                'grade' => 3,
                'admin' => true,
                'email' => 'g2220745@cc.kyoto-su.ac.jp',
                'password' => 'test12345'
            ]
        );
        User::factory()->count(10)->create();

        $this->call([
            StudioSeeder::class,
        ]);


    }
}

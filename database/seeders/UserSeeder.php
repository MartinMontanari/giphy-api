<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    const USER_TABLE_NAME = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table(self::USER_TABLE_NAME)->insert([
                'user_name' => 'User '. $i,
                'email' => 'user'. $i. '@example.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

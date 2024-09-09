<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table(self::USER_TABLE_NAME)->insert([
                'user_name' => $faker->userName,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

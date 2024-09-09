<?php

namespace Database\Seeders;

use App\domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Random\RandomException;

class UserFavoriteSeeder extends Seeder
{
    const FAVORITES_TABLE_NAME = 'favorites';

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws RandomException
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Seed skipped.');
            return;
        }

        $users->each(function ($user) {
            DB::table(self::FAVORITES_TABLE_NAME)->insert([
                'user_id' => $user->id,
                'gif_id' => bin2hex(random_bytes(8)),
                'alias' => 'Favorite ' . random_int(1, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        $this->command->info('Favorites seeded for existing users.');
    }
}

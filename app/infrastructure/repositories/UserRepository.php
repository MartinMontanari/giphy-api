<?php

namespace App\infrastructure\repositories;

use App\domain\Models\User;
use Illuminate\Support\Facades\Log;

readonly class UserRepository
{

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void
    {
        Log::info('Saving the user in the database...');
        $user->save();
    }
}

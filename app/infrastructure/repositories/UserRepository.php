<?php

namespace App\infrastructure\repositories;

use App\domain\Models\User;
use App\infrastructure\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

readonly class UserRepository
{

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user): void
    {
        Log::info('Saving the user into database...');
        $user->save();
    }

    /**
     * @param int $id
     * @return User
     */
    public function findOneById(int $id): User
    {
        Log::info("Getting the user in the database... id = $id", ["UserRepository", "- START -"]);
        $user = new User();
        $user->findOrFail($id);
        Log::info("User found... id = $id", ["UserRepository", "- END -"]);
        return $user;

    }
}

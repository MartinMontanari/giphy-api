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
        Log::info("Saving the user into database...", ["UserRepository", "- START -"]);
        $user->save();
        Log::info("Saving the user into database...", ["UserRepository", "- END -"]);
    }

    /**
     * @param int $id
     * @return User
     */
    public function findOneById(int $id): User
    {
        Log::info("Getting the user from database... id = $id", ["UserRepository", "- START -"]);
        $user = new User();
        $user->findOrFail($id);
        Log::info("User found... id = $id", ["UserRepository", "- END -"]);
        return $user;
    }


    /**
     * @param string $email
     * @return User
     */
    public function findOneByEmail(string $email): User
    {
        Log::info("Getting the user from database... email = $email", ["UserRepository", "- START -"]);
        $user = new User();
        $user->query()
            ->where('email','=',$email)
            ->first();
        Log::info("User found... email = $email", ["UserRepository", "- END -"]);
        return $user;
    }
}

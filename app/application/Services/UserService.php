<?php

namespace App\application\Services;

use App\infrastructure\repositories\UserRepository;
use Illuminate\Support\Facades\Log;

readonly class UserService
{

    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function saveUser(UserDTO $userData): void
    {
        try {
            $user = $userData->user;

            $this->userRepository->save($user);
            Log::info("User to save...", ["UserService"], [$userData]);
        } catch (UserException $exception) {
            Log::error("User saving failed...", ["UserService"], [$exception->getMessage()]);
            throw $exception;
        }
    }
}

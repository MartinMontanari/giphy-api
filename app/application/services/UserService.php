<?php
declare(strict_types=1);

namespace App\application\services;

use App\application\commands\Auth\RegisterUserCommand;
use App\domain\Models\User;
use App\infrastructure\repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class UserService
{

    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function saveUser(RegisterUserCommand $registerUserCommand): void
    {
        try {
            $userData = $registerUserCommand->getData();
            $hashedPassword = Hash::make($userData['password']);
            $user = new User(
                $userData['userName'],
                $userData['firstName'],
                $userData['lastName'],
                $userData['email'],
                $hashedPassword
            );

            $this->userRepository->save($user);
            Log::info("User to save...", ["UserService"], [$userData]);
        } catch (UserException $exception) {
            Log::error("User saving failed...", ["UserService"], [$exception->getMessage()]);
            throw $exception;
        }
    }
}

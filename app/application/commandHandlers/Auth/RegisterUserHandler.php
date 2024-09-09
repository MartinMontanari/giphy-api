<?php

namespace App\application\commandHandlers\Auth;

use App\application\commands\Auth\RegisterUserCommand;
use App\infrastructure\Exceptions\RepositoryException;
use App\infrastructure\services\OauthService;
use App\infrastructure\services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class RegisterUserHandler
{

    public function __construct(
        private UserService  $userService,
        private OauthService $oauthService
    )
    {
    }

    /**
     * @param RegisterUserCommand $command
     * @return void
     */
    public function handle(RegisterUserCommand $command): void
    {
        $userData = $command->getData();
        $oauthClientName = $userData['userName'] . '-' . $userData['email'];
        $hashedPassword = Hash::make($userData['password']);
        $filteredUserData = array_filter($userData, function ($value, $key) {
            return $key !== 'password';
        }, ARRAY_FILTER_USE_BOTH);
        Log::info('Processing RegisterUserCommand', ["RegisterUserHandler", "- START -", $filteredUserData]);

        $userId = $this->userService->saveUser($userData, $hashedPassword);
        $this->oauthService->createPassportClient($oauthClientName, $userId);

        Log::info('Processing RegisterUserCommand', ["RegisterUserHandler", "- END -", $filteredUserData]);
    }
}

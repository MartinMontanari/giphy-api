<?php

namespace App\application\commandHandlers\Auth;

use App\application\commands\Auth\RegisterOauthClientCommand;
use App\infrastructure\Exceptions\RepositoryException;
use App\infrastructure\services\OauthService;
use App\infrastructure\services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class RegisterOauthClientHandler
{

    public function __construct(
        private UserService  $userService,
        private OauthService $oauthService
    )
    {
    }

    /**
     * @param RegisterOauthClientCommand $command
     * @return void
     */
    public function handle(RegisterOauthClientCommand $command): void
    {
        $userData = $command->getData();
        $oauthClientName = $userData['userName'] . '-' . $userData['email'];
        $hashedPassword = Hash::make($userData['password']);
        $filteredUserData = array_filter($userData, function ($value, $key) {
            return $key !== 'password';
        }, ARRAY_FILTER_USE_BOTH);
        Log::info('Processing RegisterOauthClientCommand', ["RegisterUserHandler", "- START -", $filteredUserData]);

        $userId = $this->userService->saveUser($userData, $hashedPassword);
        $this->oauthService->createPassportClient($oauthClientName, $userId);

        Log::info('Processing RegisterOauthClientCommand', ["RegisterUserHandler", "- END -", $filteredUserData]);
    }
}

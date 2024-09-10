<?php

namespace App\application\commandHandlers\Auth;

use App\application\commands\Auth\LoginOauthClientCommand;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\Exceptions\UnauthorizedException;
use App\infrastructure\services\OauthService;
use App\infrastructure\services\UserService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

readonly class LoginOauthClientHandler
{

    public function __construct(
        private UserService $userService,
        private OauthService $oauthService
    )
    {
    }

    /**
     * @param LoginOauthClientCommand $command
     * @return string
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function handle(LoginOauthClientCommand $command): string
    {
        Log::info('Processing LoginOauthClientCommand', ["LoginOauthClientHandler", "- START -", $command->getData()['email']]);
        $userEmail = $command->getData()['email'];
        $plainUserPassword = $command->getData()['password'];
        $user = $this->userService->loginAttempt($userEmail, $plainUserPassword);
        Log::info('LoginOauthClientCommand in progress, user logged in.', ["LoginOauthClientHandler", "- PROCESSING -", $command->getData()['email']]);
        $token = $this->oauthService->generatePasswordGrantOauthToken($user);
        Log::info('LoginOauthClientCommand processed.', ["LoginOauthClientHandler", "- END -", $command->getData()['email']]);

        return $token;
    }
}

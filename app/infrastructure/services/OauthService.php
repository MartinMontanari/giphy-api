<?php

namespace App\infrastructure\services;

use App\domain\Models\User;
use App\infrastructure\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;

readonly class OauthService
{
    /**
     * @param string $name
     * @param int $userId
     * @return void
     */
    public function createPassportClient(string $name, int $userId): void
    {
        Log::info("Passport client creation -> $name", ["OauthService", "createPassportClient($name)", "- START -"]);

        Client::create([
            'name' => $name,
            'user_id' => $userId,
            'redirect' => config('passport.oauth.urls.redirect'),
            'provider' => "giphy-api-wrapper",
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);
        Log::info("Passport client creation -> $name", ["OauthService", "createPassportClient($name)", "- END -"]);
    }

    /**
     * @param User $user
     * @return string
     * @throws NotFoundException
     */
    public function generatePasswordGrantOauthToken(User $user): string
    {
        Log::info("Generating password grant access token...", ["OauthService", "generatePasswordGrantOauthToken()", "- START -"]);
        $oauthClient = Client::where('user_id', $user['id'])->first();

        if (!$oauthClient) {
            throw new  NotFoundException(["No client found for user with id: " . $user['id']]);
        }

        $accessToken = $user->createToken('password_grant_access_token', ['view-account', 'edit-account'])->accessToken;
        Log::info("Generating password grant access token...", ["OauthService", "generatePasswordGrantOauthToken()", "- END -"]);

        return $accessToken;
    }
}

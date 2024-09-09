<?php

namespace App\infrastructure\services;

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
}

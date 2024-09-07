<?php

namespace App\application\services;

use App\domain\Models\User;
use Illuminate\Support\Facades\Log;

readonly class AccessTokenService
{
    public function generateAccessToken(User $user): string
    {
        Log::info("Generating access token...", ["AccessTokenService"]);
        return $user->createToken('authToken')->accessToken;
    }
}

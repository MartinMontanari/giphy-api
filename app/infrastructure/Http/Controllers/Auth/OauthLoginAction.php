<?php

namespace App\infrastructure\Http\Controllers\Auth;

use App\infrastructure\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OauthLoginAction extends Controller
{

    /**
     * @param Request $request
     * @return array|JsonResponse|mixed
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = \Http::post(config('passport.oauth.urls.redirect'), [
            'grant_type' => 'password',
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $response->json();
    }
}

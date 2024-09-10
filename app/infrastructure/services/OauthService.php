<?php

namespace App\infrastructure\services;

use App\domain\Models\User;
use App\infrastructure\Exceptions\NotFoundException;
use GuzzleHttp\Exception\GuzzleException;
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
     * @throws GuzzleException
     * @throws NotFoundException
     */
    public function generatePasswordGrantOauthToken(User $user): string
    {
        try{
            $requestTokenClient = new \GuzzleHttp\Client();
            $oauthClient = Client::where('user_id', $user['id'])->first();
//
            if (!$oauthClient) {
                throw new  NotFoundException(["No client found for user with id: ". $user['id']]);
            }

            $accessToken = $user->createToken('password_grant_access_token', ['view-account', 'edit-account'])->accessToken;
            dd($accessToken);
        } catch(\Exception $e){
            dd($e);
        }
//
//        $url = config('app.url') . '/api/oauth/token';
//
//        $response = $requestTokenClient->post($url, [
//            'form_params' => [
//                'grant_type' => 'password',
//                'client_id' => $oauthClient['id'],
//                'client_secret' => $oauthClient['secret'],
//                'username' => $user['email'],
//                'password' => $user['password'],
//                'scope' => '',
//            ]
//        ]);
//        dd($response);
        return json_decode((string)$response->getBody(), true);
    }
}

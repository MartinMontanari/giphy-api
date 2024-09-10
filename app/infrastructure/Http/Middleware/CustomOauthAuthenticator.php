<?php

namespace App\infrastructure\Http\Middleware;

use App\domain\Models\User;
use Carbon\Carbon;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomOauthAuthenticator
{

    /**
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $auth = app('auth');

        $user = $auth->guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$this->isValidToken($user, $token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Auth::setUser($user);

        return $next($request);
    }

    /**
     * @param User $user
     * @param string $token
     * @return bool
     */
    protected function isValidToken(User $user, string $token): bool
    {
        $publicKey = config('passport.public_key');
        $tokens = $user->tokens;

        foreach ($tokens as $userToken) {
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
            $expirationDate = new Carbon($decoded->exp);
            if ($userToken->id == $decoded->jti && !$userToken->revoked && $expirationDate->toDate() > now()) {
                return true;
            }
        }

        return false;
    }
}

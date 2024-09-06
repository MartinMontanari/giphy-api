<?php

namespace App\infrastructure\Http\Controllers\Auth;

use App\application\Services\UserService;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\validators\Auth\RegisterUserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{


    public function __construct(
        private readonly UserService $userService,
        private readonly RegisterUserValidator $registerUserValidator
    )
    {
    }

    public function register(Request $request)
    {
        Log::info('Holiwis');
        Log::info('Register user starting.', ["RegisterUserAction"], $request);
        $registerUserCommand = $this->registerUserValidator->validate($request);
//        $this->userService->saveUser($request->body);
        return response()->json([$request->ip() => ["Holanda" => $request->all()]]);
    }
}

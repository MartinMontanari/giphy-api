<?php

namespace App\infrastructure\Http\Controllers\Auth;

use App\application\services\UserService;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Exceptions\RepositoryException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function register(Request $request)
    {
        try{

            Log::info('Register user starting ->', ["RegisterUserAction", $request->getMethod(), $request->all()]);
            $registerUserCommand = $this->registerUserValidator->validate($request);
            $this->userService->saveUser($registerUserCommand);

            Log::info('Done, User registered Ok! ->', ["RegisterUserAction", $request->getMethod()]);
            return response()->json([$request->ip() => ["message" => "User registered ok."]])->setStatusCode(HttpCodes::CREATED);
        }
        catch (BadRequestException $exception){
            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessages()]);
            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        }
        catch (RepositoryException $exception){
            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessages()]);
            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        }
    }
}

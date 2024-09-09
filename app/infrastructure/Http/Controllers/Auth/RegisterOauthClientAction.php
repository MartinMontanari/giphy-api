<?php
//
namespace App\infrastructure\Http\Controllers\Auth;
//
//use App\domain\services\UserService;
//use App\infrastructure\Exceptions\BadRequestException;
//use App\infrastructure\Exceptions\RepositoryException;
//use App\infrastructure\Http\contracts\CustomResponse;
//use App\infrastructure\Http\Controllers\Controller;
//use App\infrastructure\Http\enums\HttpCodes;
//use App\infrastructure\Http\validators\Auth\RegisterUserValidator;
//use Illuminate\Http\JsonResponse;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;
//
//class AuthController extends Controller
//{
//
//
//    public function __construct(
//        private readonly UserService           $userService,
//        private readonly RegisterUserValidator $registerUserValidator
//    )
//    {
//    }
//
//    /**
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function register(Request $request): JsonResponse
//    {
//        try {
//            Log::info('Register user starting ->', ["OauthLoginAction", $request->getMethod(), $request->all()]);
//
//            $registerUserCommand = $this->registerUserValidator->validate($request);
//
//            $this->userService->saveUser($registerUserCommand);
//
//            Log::info('Done, User registered Ok! ->', ["OauthLoginAction", $request->getMethod()]);
//            $response = new CustomResponse("User registered ok.", []);
//
//            return response()->json($response->getResponseWithSuccess())->setStatusCode(HttpCodes::CREATED);
//        } catch (BadRequestException $exception) {
//            Log::error('Register user has failed ->', ["OauthLoginAction", $exception->getMessages()]);
//            $response = new CustomResponse('Register user has failed', $exception->getMessages());
//
//            return response()->json($response->getResponseWithError())->setStatusCode($exception->getCode());
//        } catch (RepositoryException $exception) {
//            Log::error('Register user has failed ->', ["OauthLoginAction", $exception->getMessages()]);
//            $response = new CustomResponse('Register user has failed', $exception->getMessages());
//
//            return response()->json($response->getResponseWithError())->setStatusCode($exception->getCode());
//        }
//    }
//}

use App\application\commandHandlers\Auth\RegisterUserHandler;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Exceptions\RepositoryException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\Auth\RegisterUserValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterOauthClientAction extends Controller
{
    public function __construct(
        private readonly RegisterUserHandler $registerUserHandler,
        private readonly RegisterUserValidator $registerUserValidator
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function execute(Request $request): JsonResponse
    {
        try {
            Log::info('Register user starting ->', ["OauthLoginAction", $request->getMethod(), $request->all()]);

            $registerUserCommand = $this->registerUserValidator->validate($request);
            $this->registerUserHandler->handle($registerUserCommand);

            Log::info('Done, User registered Ok! ->', ["OauthLoginAction", $request->getMethod()]);
            return response()->json()->setStatusCode(HttpCodes::CREATED);
        } catch (BadRequestException $exception) {
            Log::error('Register user has failed ->', ["OauthLoginAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (RepositoryException $exception) {
            Log::error('Register user has failed ->', ["OauthLoginAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (\Exception $exception) {
            Log::error('Register user has failed ->', ["OauthLoginAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode(HttpCodes::INTERNAL_ERROR);
        }
    }


}

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
//            Log::info('Register user starting ->', ["RegisterUserAction", $request->getMethod(), $request->all()]);
//
//            $registerUserCommand = $this->registerUserValidator->validate($request);
//
//            $this->userService->saveUser($registerUserCommand);
//
//            Log::info('Done, User registered Ok! ->', ["RegisterUserAction", $request->getMethod()]);
//            $response = new CustomResponse("User registered ok.", []);
//
//            return response()->json($response->getResponseWithSuccess())->setStatusCode(HttpCodes::CREATED);
//        } catch (BadRequestException $exception) {
//            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessages()]);
//            $response = new CustomResponse('Register user has failed', $exception->getMessages());
//
//            return response()->json($response->getResponseWithError())->setStatusCode($exception->getCode());
//        } catch (RepositoryException $exception) {
//            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessages()]);
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

class AuthController extends Controller
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
    public function register(Request $request): JsonResponse
    {
        try {
            Log::info('Register user starting ->', ["RegisterUserAction", $request->getMethod(), $request->all()]);

            $registerUserCommand = $this->registerUserValidator->validate($request);
            $this->registerUserHandler->handle($registerUserCommand);

            Log::info('Done, User registered Ok! ->', ["RegisterUserAction", $request->getMethod()]);
            return response()->json()->setStatusCode(HttpCodes::CREATED);
        } catch (BadRequestException $exception) {
            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (RepositoryException $exception) {
            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (\Exception $exception) {
            Log::error('Register user has failed ->', ["RegisterUserAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode(HttpCodes::INTERNAL_ERROR);
        }
    }

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

<?php
//
//namespace App\infrastructure\Http\Controllers\Auth;
//use App\domain\services\UserService;
//use App\infrastructure\Exceptions\BadRequestException;
//use App\infrastructure\Http\contracts\CustomResponse;
//use App\infrastructure\Http\Controllers\Controller;
//use App\infrastructure\Http\validators\Auth\LoginUserValidator;
//use Illuminate\Http\JsonResponse;
//use Illuminate\Http\Request;
//
//class LoginController extends Controller
//{
//
//    public function __construct(
//        private readonly UserService $userService,
//        private readonly LoginUserValidator $loginUserValidator
//    )
//    {
//    }
//
//    /**
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function execute(Request $request): JsonResponse
//    {
//        try {
//            Log::info('Register user starting ->', ["RegisterUserAction", $request->getMethod(), $request->all()]);
//
//            $loginUserCommand = $this->loginUserValidator->validate($request);
//
//            $token = $this->userService->logInUser($loginUserCommand);
//
//            Log::info('Done, User registered Ok! ->', ["RegisterUserAction", $request->getMethod()]);
//
////            return response()->json($response->getResponseWithSuccess())->setStatusCode(HttpCodes::CREATED);
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

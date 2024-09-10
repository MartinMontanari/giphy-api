<?php
//
namespace App\infrastructure\Http\Controllers\Auth;
use App\application\commandHandlers\Auth\RegisterOauthClientHandler;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Exceptions\RepositoryException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\Auth\RegisterOauthClientValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterOauthClientAction extends Controller
{
    public function __construct(
        private readonly RegisterOauthClientHandler $registerOauthClientHandler,
        private readonly RegisterOauthClientValidator $registerOauthClientValidator
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
            Log::info('Register user starting ->', ["LoginOauthClientAction", $request->getMethod(), $request->all()]);

            $registerUserCommand = $this->registerOauthClientValidator->validate($request);
            $this->registerOauthClientHandler->handle($registerUserCommand);

            Log::info('Done, User registered Ok! ->', ["LoginOauthClientAction", $request->getMethod()]);
            return response()->json()->setStatusCode(HttpCodes::CREATED);
        } catch (BadRequestException $exception) {
            Log::error('Register user has failed ->', ["LoginOauthClientAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (\Exception $exception) {
            Log::error('Register user has failed ->', ["LoginOauthClientAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode(HttpCodes::INTERNAL_ERROR);
        }
    }


}

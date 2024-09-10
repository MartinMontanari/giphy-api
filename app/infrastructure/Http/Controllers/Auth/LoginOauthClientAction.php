<?php

namespace App\infrastructure\Http\Controllers\Auth;

use App\application\commandHandlers\Auth\LoginOauthClientHandler;
use App\application\commands\Auth\LoginOauthClientCommand;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\Exceptions\UnauthorizedException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\Auth\LoginOauthClientValidator;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginOauthClientAction extends Controller
{
    public function __construct(
        private readonly LoginOauthClientValidator $loginOauthClientValidator,
        private readonly LoginOauthClientHandler   $loginOauthClientHandler,
    )
    {
    }


    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function execute(Request $request)
    {
        try {
            Log::info('Login Oauth user case starting... ->', ["LoginOauthClientAction", $request->getMethod(), $request->all()['email']]);
            /** @var LoginOauthClientCommand $command */
            $command = $this->loginOauthClientValidator->validate($request);

            $personalAccessToken = $this->loginOauthClientHandler->handle($command);
            Log::info('Login Oauth user done... ->', ["LoginOauthClientAction", $request->getMethod(), $request->all()['email']]);

            return response()->json(['access_token' => $personalAccessToken])->setStatusCode(HttpCodes::OK);
        } catch (BadRequestException $exception) {
            Log::error('Oauth login failed ->', ["LoginOauthClientAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (UnauthorizedException $exception) {
            Log::error('Oauth login failed ->', ["LoginOauthClientAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (NotFoundException $exception) {
            Log::error('Oauth login failed ->', ["LoginOauthClientAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (GuzzleException $exception) {
            Log::error('Oauth login failed ->', ["LoginOauthClientAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode($exception->getCode());
        } catch (\Exception $exception) {
            Log::error('Oauth login failed ->', ["LoginOauthClientAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode(HttpCodes::INTERNAL_ERROR);
        }

    }
}

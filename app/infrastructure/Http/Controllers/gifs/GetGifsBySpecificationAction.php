<?php

namespace App\infrastructure\Http\Controllers\gifs;

use App\application\queryHandlers\Gifs\GetGifsBySpecificationHandler;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Exceptions\RepositoryException;
use App\infrastructure\Exceptions\ServiceException;
use App\infrastructure\Http\contracts\CustomResponse;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\Gifs\GetGifsBySpecificationValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class GetGifsBySpecificationAction extends Controller
{
    public function __construct(
        private readonly GetGifsBySpecificationHandler $getBySpecificationHandler,
        private readonly GetGifsBySpecificationValidator $getGifsBySpecificationValidator
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ServiceException
     */
    public function execute(Request $request): JsonResponse
    {
        try {
            Log::info('Search gifs by SPECIFICATION use case starting ->', ["GetGifsBySpecificationAction", $request->getMethod(), $request->all()]);
            $getGifsBySpecificationQuery = $this->getGifsBySpecificationValidator->validate($request);
            $searchResult = $this->getBySpecificationHandler->handle($getGifsBySpecificationQuery);

            return response()->json($searchResult)->setStatusCode(HttpCodes::OK);
        } catch (BadRequestException $exception) {
            Log::error('Search gifs by specification has failed ->', ["GetGifsBySpecificationAction", $exception->getMessages()]);

            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        } catch (ServiceException $exception) {
            Log::error('Search gifs by specification has failed ->', ["GetGifsBySpecificationAction", $exception->getMessages()]);

            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        }
        catch (\Exception $exception) {
            Log::error('Something is wrong with the specification query.', ["GetGifsBySpecificationAction", $exception->getMessages()]);

            return response()->json($exception->getMessage())->setStatusCode($exception->getCode());
        }
    }
}

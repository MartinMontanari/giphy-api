<?php

namespace App\infrastructure\Http\Controllers\gifs;

use App\application\queries\Gifs\GetIfByIdQuery;
use App\application\queryHandlers\Gifs\GetGifByIdHandler;
use App\application\queryHandlers\Gifs\GetGifsBySpecificationHandler;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Exceptions\ServiceException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\Gifs\GetGifByIdValidator;
use App\infrastructure\Http\validators\Gifs\GetGifsBySpecificationValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class GetGifByIdAction extends Controller
{
    public function __construct(
        private readonly GetGifByIdHandler $getGifByIdHandler,
        private readonly GetGifByIdValidator $getGifByIdValidator
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
            Log::info('Search gifs by ID use case starting ->', ["GetGifByIdAction", $request->getMethod(), $request->all()]);
            /** @var GetIfByIdQuery $getGifByIdQuery */
            $getGifByIdQuery = $this->getGifByIdValidator->validate($request);

            /** @var Collection $searchResult */
            $searchResult = $this->getGifByIdHandler->handle($getGifByIdQuery);

            return response()->json($searchResult)->setStatusCode(HttpCodes::OK);
        } catch (BadRequestException $exception) {
            Log::error('Search gif by id has failed ->', ["GetGifsBySpecificationAction", $exception->getMessages()]);

            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        } catch (ServiceException $exception) {
            Log::error('Search gifs by specification has failed ->', ["GetGifsBySpecificationAction", $exception->getMessages()]);

            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        }
        catch (\Exception $exception) {
            Log::error('Search gifs by specification has failed.', ["GetGifsBySpecificationAction", $exception->getMessage()]);

            return response()->json($exception->getMessage())->setStatusCode($exception->getCode());
        }
    }
}

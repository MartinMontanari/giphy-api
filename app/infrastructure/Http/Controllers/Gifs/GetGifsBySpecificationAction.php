<?php

namespace App\infrastructure\Http\Controllers\Gifs;

use App\application\queries\Gifs\GetGifsBySpecificationQuery;
use App\application\queryHandlers\Gifs\GetGifsBySpecificationHandler;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\Gifs\GetGifsBySpecificationValidator;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
     */
    public function execute(Request $request): JsonResponse
    {
        try {
            Log::info('Search gifs by SPECIFICATION use case starting ->', ["GetGifsBySpecificationAction", $request->getMethod(), $request->all()]);

            /** @var GetGifsBySpecificationQuery $getGifsBySpecificationQuery */
            $getGifsBySpecificationQuery = $this->getGifsBySpecificationValidator->validate($request);

            /** @var Collection $searchResult */
            $searchResult = $this->getBySpecificationHandler->handle($getGifsBySpecificationQuery);

            return response()->json($searchResult)->setStatusCode(HttpCodes::OK);
        } catch (BadRequestException $exception) {
            Log::error('Search gifs by specification has failed ->', ["GetGifsBySpecificationAction", $exception->getMessages()]);

            return response()->json(["error" => $exception->getMessages()])->setStatusCode($exception->getCode());
        } catch (GuzzleException $exception) {
            Log::error('Search gifs by specification has failed ->', ["GetGifsBySpecificationAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode($exception->getCode());
        }
        catch (\Exception $exception) {
            Log::error('Something is wrong with the specification query.', ["GetGifsBySpecificationAction", $exception->getMessage()]);

            return response()->json(["error" => $exception->getMessage()])->setStatusCode(HttpCodes::INTERNAL_ERROR);
        }
    }
}

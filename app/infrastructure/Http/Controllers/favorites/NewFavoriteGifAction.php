<?php

namespace App\infrastructure\Http\Controllers\favorites;

use App\application\commandHandlers\favorites\NewFavoriteGifHandler;
use App\application\commands\favorites\NewFavoriteGifCommand;
use App\infrastructure\Exceptions\BadRequestException;
use App\infrastructure\Http\Controllers\Controller;
use App\infrastructure\Http\enums\HttpCodes;
use App\infrastructure\Http\validators\favorites\NewFavoriteGifValidator;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class NewFavoriteGifAction extends Controller
{
    public function __construct(
        private readonly NewFavoriteGifHandler $newFavoriteGifHandler,
        private readonly NewFavoriteGifValidator $newFavoriteGifValidator
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
//     * @throws GuzzleException
     */
    public function execute(Request $request): JsonResponse
    {
        try {
            Log::info('Search gifs by ID use case starting ->', ["NewFavoriteGifAction", $request->getMethod(), $request->all()]);
            /** @var NewFavoriteGifCommand $newFavoriteGifCommand */
            $newFavoriteGifCommand = $this->newFavoriteGifValidator->validate($request);

            /** @var Collection $searchResult */
            $this->newFavoriteGifHandler->handle($newFavoriteGifCommand);

            return response()->json(["message" => "Done."])->setStatusCode(HttpCodes::OK);
        } catch (BadRequestException $exception) {
            Log::error('New favorite gif has failed ->', ["NewFavoriteGifAction", $exception->getMessages()]);

            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
        }
//        catch (NotFoundException $exception) {
//            Log::error('Search gif by id has failed ->', ["NewFavoriteGifAction", $exception->getMessages()]);
//
//            return response()->json($exception->getMessages())->setStatusCode($exception->getCode());
//        } catch (\Exception $exception) {
//            Log::error('Search gifs by specification has failed.', ["GetGifsBySpecificationAction", $exception->getMessage()]);
//
//            return response()->json($exception->getMessage())->setStatusCode($exception->getCode());
//        }
    }
}

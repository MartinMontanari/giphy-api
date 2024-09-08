<?php

namespace App\application\queryHandlers\Gifs;

use App\application\queries\Gifs\GetGifsBySpecificationQuery;
use App\application\queries\Gifs\GetIfByIdQuery;
use App\infrastructure\Exceptions\ServiceException;
use App\infrastructure\services\GiphyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class GetGifByIdHandler
{

    public function __construct(
//        private GifRepository $gifRepository,
        private GiphyService $gifService
    )
    {
    }

    /**
     * @param  GetIfByIdQuery $query
     * @return Collection
     * @throws ServiceException
     */
    public function handle(GetIfByIdQuery $query): Collection
    {
        try {
            Log::info('Processing GetIfByIdQuery', ["GetGifByIdHandler", "- START -", $query->getData()]);
            (string)$gifId = $query->getData()['id'];

            $response = $this->gifService->getGifById($gifId);
            Log::info('GetIfByIdQuery processed ok.', ["GetGifByIdHandler", "- DONE -", $query->getData()]);
            return $response;
        }
        catch (GuzzleException $exception) {
            throw new ServiceException([$exception->getMessage()]);
        }
    }
}

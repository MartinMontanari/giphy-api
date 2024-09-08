<?php

namespace App\application\queryHandlers\Gifs;

use App\application\queries\Gifs\GetGifsBySpecificationQuery;
use App\infrastructure\Exceptions\ServiceException;
use App\infrastructure\services\GiphyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class GetGifsBySpecificationHandler
{

    public function __construct(
//        private GifRepository $gifRepository,
        private GiphyService $gifService
    )
    {
    }

    /**
     * @param GetGifsBySpecificationQuery $query
     * @return Collection
     * @throws ServiceException
     */
    public function handle(GetGifsBySpecificationQuery $query): Collection
    {
        try {
            Log::info('Processing GetGifsBySpecificationQuery', ["GetGifsBySpecificationHandler", "- START -", $query->getData()]);
            (string)$queryPhrase = $query->getData()['query'];
            (int)$limit = $query->getData()['limit'] ?? 10;
            (int)$offset = $query->getData()['offset'] ?? 0;


            /** @var Collection $response */
            $response = $this->gifService->searchGifs($queryPhrase, $limit, $offset);
            Log::info('GetGifsBySpecificationQuery processed ok.', ["GetGifsBySpecificationHandler", "- END -", $query->getData()]);
            return $response;
        }
        catch (GuzzleException $exception) {
            throw new ServiceException([$exception->getMessage()]);
        }
    }
}

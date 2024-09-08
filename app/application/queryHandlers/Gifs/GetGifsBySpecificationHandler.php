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
            $queryPhrase = $query->getData()['query'];
            $limit = $query->getData()['limit'] ?? 10;
            $offset = $query->getData()['offset'] ?? 0;

            return $this->gifService->searchGifs($queryPhrase, $limit, $offset);
        }
        catch (GuzzleException $exception) {
            throw new ServiceException([$exception->getMessage()]);
        }
    }
}

<?php

namespace App\infrastructure\services;

use App\infrastructure\Exceptions\NotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class GiphyService
{
    const GIPHY_SEARCH_PATH = "/search";
    const GIPHY_GET_BY_ID_PATH = "/";
    protected string $giphyBaseUrl;
    protected string $giphySecretKey;

    public function __construct
    (
        private Client $client = new Client(),
    )
    {
        $this->giphyBaseUrl = config('app.services.giphy.baseUrl');
        $this->giphySecretKey = config('app.services.giphy.apiKey');
    }

    /**
     * @param string $query
     * @param int $limit
     * @param int $offset
     * @return Collection
     * @throws GuzzleException
     */
    public function searchGifs(string $query, int $limit, int $offset): Collection
    {
        Log::info("Searching gifs by -> $query", ["GiphyService", "searchGifs()", "- START -"]);
        $giphySearchResult = $this->client->get($this->giphyBaseUrl . self::GIPHY_SEARCH_PATH, [
            'query' => [
                'api_key' => $this->giphySecretKey,
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset,
            ]
        ]);

        $decodedSearchGiphyResultCollection = new Collection(json_decode($giphySearchResult->getBody(), true));
        Log::info("Search done.", ["GiphyService", "searchGifs()", "- END -"]);

        return $decodedSearchGiphyResultCollection;
    }

    /**
     * @param string $id
     * @return Collection
     * @throws GuzzleException
     * @throws NotFoundException
     */
    public function getGifById(string $id): Collection
    {
        try {
            Log::info("Searching gif for id -> $id",
                ["GiphyService",
                    "getGifById($id)",
                    "- START -"
                ]);
            $giphySearchResult = $this->client->get($this->giphyBaseUrl . self::GIPHY_GET_BY_ID_PATH . $id, [
                'query' => [
                    'api_key' => $this->giphySecretKey,
                ]
            ]);

            $decodedSearchGiphyResultCollection = new Collection(json_decode($giphySearchResult->getBody()->getContents(), true));
            Log::info("Gif for -> $id found.",
                ["GiphyService",
                    "getGifById($id)",
                    "- END -"
                ]);

            return $decodedSearchGiphyResultCollection;
        } catch (ClientException $exception) {
            $errorResponse = $exception->getResponse();
            $errorBody = $errorResponse->getBody()->getContents();
            $errorData = json_decode($errorBody, true);

            Log::error("Error fetching GIF for id -> $id", ["GiphyService", "getGifById($id)", "Error" => $errorData]);

            if ($errorData['meta']['status'] === 404) {
                throw new NotFoundException($errorData['meta']);
            }
            throw $exception;
        }
    }
}

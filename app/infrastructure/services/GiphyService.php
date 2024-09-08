<?php

namespace App\infrastructure\services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class GiphyService
{
    const GIPHY_SEARCH_PATH = "/search";
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
        Log::info("Searching gifs by -> $query", ["GiphyService", "searchGifs()" ,"- START -"]);
        $giphySearchResult = $this->client->get($this->giphyBaseUrl . self::GIPHY_SEARCH_PATH, [
            'query' => [
                'api_key' => $this->giphySecretKey,
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset,
            ]
        ]);

        $decodedSearchGiphyResultCollection = new Collection(json_decode($giphySearchResult->getBody(), true));
        Log::info("Search resulted ok.", ["GiphyService", "searchGifs()", "- END -"]);

        return $decodedSearchGiphyResultCollection;
    }

    public function getGifById(string $id)
    {
        return Http::get($this->giphyBaseUrl . $id, [
            'api_key' => $this->giphySecretKey,
        ])->json();
    }
}

<?php
namespace App\application\services;

use Illuminate\Support\Facades\Http;

class GiphyService
{
    private string $giphyBaseUrl = config('app.services.giphy.baseUrl', );
//    protected string $apiKey =

    public function searchGifs($query, $limit = 10, $offset = 0)
    {
        return Http::get($this->baseUrl . 'search', [
            'api_key' => $this->apiKey,
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset
        ])->json();
    }

    public function getGifById($id)
    {
        return Http::get($this->baseUrl . $id, [
            'api_key' => $this->apiKey,
        ])->json();
    }
}

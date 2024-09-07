<?php

namespace App\application\services;

use Illuminate\Support\Facades\Http;

readonly class GiphyService
{
//    protected string $baseUrl = "asdasd";
//    protected string  $apiKey = "asdasd";

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

<?php

namespace App\application\commandHandlers\favorites;

use App\application\commands\favorites\NewFavoriteGifCommand;
use App\application\queries\Gifs\GetIfByIdQuery;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\services\GiphyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class NewFavoriteGifHandler
{

    public function __construct(
    )
    {
    }


    public function handle(NewFavoriteGifCommand $command): Collection
    {
        Log::info('Processing NewFavoriteGifCommand', ["NewFavoriteGifHandler", "- START -", $command->getData()]);

//        $response = $this->gifService->getGifById($gifId);
        Log::info('NewFavoriteGifCommand processed ok.', ["NewFavoriteGifHandler", "- DONE -", $command->getData()]);
//        return $response;
    }
}

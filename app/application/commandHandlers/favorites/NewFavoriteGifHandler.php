<?php

namespace App\application\commandHandlers\favorites;

use App\application\commands\favorites\NewFavoriteGifCommand;
use App\domain\Models\Favorite;
use App\domain\services\UserService;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\services\GiphyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class NewFavoriteGifHandler
{

    public function __construct(
        private UserService $userService,
        private GiphyService $gifService,
    )
    {
    }

    /**
     * @param NewFavoriteGifCommand $command
     * @return Collection
     * @throws NotFoundException
     * @throws GuzzleException
     */
    public function handle(NewFavoriteGifCommand $command): Collection
    {
        Log::info('Processing NewFavoriteGifCommand', ["NewFavoriteGifHandler", "- START -", $command->getData()]);
        $userId = $command->getData()['user_id'];
        $alias = $command->getData()['alias'];
        $gifId = $command->getData()['gif_id'];

        $this->userService->checkIfUserExists($userId);
        $this->gifService->checkIfGifExists($gifId);

        $favorite = new Favorite();
        Log::info('NewFavoriteGifCommand processed ok.', ["NewFavoriteGifHandler", "- DONE -", $command->getData()]);
//        return $response;
    }
}

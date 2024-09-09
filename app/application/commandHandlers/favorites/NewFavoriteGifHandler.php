<?php

namespace App\application\commandHandlers\favorites;

use App\application\commands\favorites\NewFavoriteGifCommand;
use App\domain\Models\Favorite;
use App\domain\services\UserService;
use App\infrastructure\Exceptions\NotFoundException;
use App\infrastructure\repositories\FavoriteRepository;
use App\infrastructure\services\GiphyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class NewFavoriteGifHandler
{

    public function __construct(
        private UserService $userService,
        private GiphyService $gifService,
        private FavoriteRepository $favoriteRepository
    )
    {
    }

    /**
     * @param NewFavoriteGifCommand $command
     * @return void
     * @throws GuzzleException
     * @throws NotFoundException
     */
    public function handle(NewFavoriteGifCommand $command): void
    {
        Log::info('Processing NewFavoriteGifCommand', ["NewFavoriteGifHandler", "- START -", $command->getData()]);
        $userId = $command->getData()['user_id'];
        $alias = $command->getData()['alias'];
        $gifId = $command->getData()['gif_id'];

        $this->userService->checkIfUserExists($userId);
        $this->gifService->checkIfGifExists($gifId);

        $favorite = new Favorite();
        $favorite->user_id = $userId;
        $favorite->gif_id = $gifId;
        $favorite->alias = $alias;

        $this->favoriteRepository->save($favorite);
        Log::info('NewFavoriteGifCommand processed ok.', ["NewFavoriteGifHandler", "- DONE -", $command->getData()]);
    }
}

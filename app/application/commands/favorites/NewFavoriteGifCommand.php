<?php

namespace App\application\commands\favorites;


readonly class NewFavoriteGifCommand
{

    public function __construct(
        private string     $gifId,
        private string     $alias,
        private int $userId,
    )
    {
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'gif_id' => $this->gifId,
            'alias' => $this->alias,
            'user_id' => $this->userId,
        ];
    }
}

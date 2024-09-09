<?php

namespace App\application\commands\favorites;

use phpseclib3\Math\BigInteger;

readonly class NewFavoriteGifCommand
{

    public function __construct(
        private BigInteger $userId,
        private string     $gifId,
        private string     $alias,
    )
    {
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'gif_id' => $this->gifId,
            'alias' => $this->alias,
        ];
    }
}

<?php

namespace App\application\queries\Gifs;

readonly class GetIfByIdQuery
{
    public function __construct(
        private string $id,
    )
    {
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}

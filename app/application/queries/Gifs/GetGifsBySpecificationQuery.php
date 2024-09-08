<?php

namespace App\application\queries\Gifs;

readonly class GetGifsBySpecificationQuery
{
    public function __construct(
        private string   $query,
        private int|null $limit = null,
        private int|null $offset = null,
    )
    {
    }

    public function getData(): array
    {
        return [
            'query' => $this->query,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ];
    }
}

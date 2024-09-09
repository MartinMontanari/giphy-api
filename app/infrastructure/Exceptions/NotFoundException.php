<?php

namespace App\infrastructure\Exceptions;

use App\infrastructure\Http\enums\HttpCodes;
use Exception;

class NotFoundException extends Exception
{
    private array $messages;

    public function __construct(
        array $message,
        null|int $code = HttpCodes::NOT_FOUND)
    {
        $this->messages = $message;
        $this->code = $code;
        parent::__construct();
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}

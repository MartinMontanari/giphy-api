<?php

namespace App\infrastructure\Http\exceptions;

use App\infrastructure\Http\enums\HttpCodes;
use Exception;

class BadRequestException extends Exception
{
    private array $messages;

    public function __construct(
        array $message,
        $code = HttpCodes::BAD_REQUEST)
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

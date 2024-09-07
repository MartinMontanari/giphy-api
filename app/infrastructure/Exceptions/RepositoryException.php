<?php

namespace App\infrastructure\Exceptions;

use App\infrastructure\Http\enums\HttpCodes;
use Exception;

class RepositoryException extends Exception
{
    private array $messages;

    public function __construct(
        array $message,
        null|int $code = HttpCodes::UNPROCESSABLE_ENTITY)
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

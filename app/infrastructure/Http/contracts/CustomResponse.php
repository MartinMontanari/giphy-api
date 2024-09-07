<?php

namespace App\infrastructure\Http\contracts;

readonly class CustomResponse
{
    protected string|array $message;
    protected object|array $data;

    /**
     * @param string|array $message
     * @param object|array $data
     */
    public function __construct(string|array $message, object|array $data)
    {
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getResponseWithSuccess(): array
    {
        return [
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    /**
     * @return array
     */
    public function getResponseWithError(): array
    {
        return [
            'message' => $this->message,
            'error' => $this->data,
        ];
    }
}

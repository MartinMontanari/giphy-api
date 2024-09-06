<?php

namespace App\application\commands\Auth;

readonly class RegisterUserCommand
{

    public function __construct(
        private string $userName,
        private string $firstname,
        private string $lastName,
        private string $email,
        private string $password,
    )
    {
    }

    public function getData(): array{
        return [
            'userName' => $this->userName,
            'firstName' => $this->firstname,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

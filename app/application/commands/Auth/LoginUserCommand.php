<?php

namespace App\application\commands\Auth;

readonly class LoginUserCommand
{
    private string $email;
    private string $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getData(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}

<?php

namespace App\infrastructure\Http\validators\Auth;

use App\application\commands\Auth\LoginUserCommand;
use App\infrastructure\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginUserValidator
{


    /**
     * @param Request $request
     * @return LoginUserCommand
     * @throws BadRequestException
     */
    public function validate(Request $request): LoginUserCommand
    {
        $validate = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if($validate->fails()){
            throw new BadRequestException($validate->errors()->getMessages());
        }
        return new LoginUserCommand(
            $request->input('email'),
            $request->input('password'),
        );
    }

    private function getRules() : array
    {
        return [
            'email' => 'bail|required|min:8|max:30',
            'password' => 'bail|required|min:8|max:30',
        ];
    }

    private function getMessages(): array {
        return [
            'email.required' => 'The email is required.',
            'email.email' => 'The email is not a valid email.',
            'email.max' => 'The email has to be 100 chars max.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password has to be 8 chars min.',
            'password.max' => 'The password has to be 24 chars max.',
        ];
    }
}

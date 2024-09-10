<?php

namespace App\infrastructure\Http\validators\Auth;

use App\application\commands\Auth\RegisterOauthClientCommand;
use App\infrastructure\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

readonly class RegisterOauthClientValidator
{


    /**
     * @param Request $request
     * @return RegisterOauthClientCommand
     * @throws BadRequestException
     */
    public function validate(Request $request): RegisterOauthClientCommand
    {
        $validate = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if($validate->fails()){
            throw new BadRequestException($validate->errors()->getMessages());
        }
        return new RegisterOauthClientCommand(
            $request->input('userName'),
            $request->input('firstName'),
            $request->input('lastName'),
            $request->input('email'),
            $request->input('password'),
        );
    }

    private function getRules() : array
    {
        return [
            'userName' => 'bail|required|min:8|max:30',
            'firstName' => 'bail|required|min:1|max:30',
            'lastName' => 'bail|required|min:1|max:30',
            'email' => 'bail|required|email|max:100',
            'password' => 'bail|required|min:8|max:24',
        ];
    }

    private function getMessages(): array {
        return [
            'userName.required' => 'The userName is required.',
            'userName.min' => 'The userName has to be 8 chars min.',
            'userName.max' => 'The userName has to be 30 chars max.',
            'firstName.required' => 'The firstName is required.',
            'firstName.min' => 'The firstName has to be 1 char min.',
            'firstName.max' => 'The firstName has to be 30 chars max.',
            'lastName.required' => 'The lastName is required.',
            'lastName.min' => 'The lastName has to be 1 char min.',
            'lastName.max' => 'The lastName has to be 30 chars max.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email is not a valid email.',
            'email.max' => 'The email has to be 100 chars max.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password has to be 8 chars min.',
            'password.max' => 'The password has to be 24 chars max.',
        ];
    }
}

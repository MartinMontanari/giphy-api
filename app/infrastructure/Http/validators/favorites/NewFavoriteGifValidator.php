<?php

namespace App\infrastructure\Http\validators\favorites;

use App\application\commands\favorites\NewFavoriteGifCommand;
use App\infrastructure\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

readonly class NewFavoriteGifValidator
{
    /**
     * @param Request $request
     * @return NewFavoriteGifCommand
     * @throws BadRequestException
     */
    public function validate(Request $request): NewFavoriteGifCommand
    {
        $validate = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if ($validate->fails()) {
            throw new BadRequestException($validate->errors()->getMessages());
        }
        return new NewFavoriteGifCommand(
            $request->input('gif_id'),
            $request->input('alias'),
            $request->input('user_id'),

        );
    }

    private function getRules(): array
    {
        return [
            'gif_id' => 'bail|required|string',
            'alias' => 'bail|required|string',
            'user_id' => 'bail|required|numeric|min:1',
        ];
    }

    private function getMessages(): array
    {
        return [
            'gif_id.required' => 'The gif_id is required.',
            'gif_id.string' => 'The gif_id must be string.',
            'alias.required' => 'The alias is required.',
            'alias.string' => 'The alias must be string.',
            'user_id.required' => 'The user_id is required.',
            'user_id.numeric' => 'The user_id must be number.',
            'user_id.min' => 'The user_id must be min 1.',
        ];
    }
}

<?php

namespace App\infrastructure\Http\validators\Gifs;

use App\application\queries\Gifs\GetGifsBySpecificationQuery;
use App\application\queries\Gifs\GetIfByIdQuery;
use App\infrastructure\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

readonly class GetGifByIdValidator
{
    /**
     * @param Request $request
     * @return GetIfByIdQuery
     * @throws BadRequestException
     */
    public function validate(Request $request): GetIfByIdQuery
    {
        $validate = Validator::make(['id' =>$request->route('id')], $this->getRules(), $this->getMessages());

        if ($validate->fails()) {
            throw new BadRequestException($validate->errors()->getMessages());
        }
        return new GetIfByIdQuery(
            $request->route('id'),
        );
    }

    private function getRules() : array
    {
        return [
            'id' => 'bail|required',
        ];
    }

    private function getMessages(): array {
        return [
            'id.required' => 'The id is required.',
        ];
    }
}

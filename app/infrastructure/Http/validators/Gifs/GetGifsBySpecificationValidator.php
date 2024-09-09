<?php

namespace App\infrastructure\Http\validators\Gifs;

use App\application\queries\Gifs\GetGifsBySpecificationQuery;
use App\infrastructure\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

readonly class GetGifsBySpecificationValidator
{
    /**
     * @param Request $request
     * @return GetGifsBySpecificationQuery
     * @throws BadRequestException
     */
    public function validate(Request $request): GetGifsBySpecificationQuery
    {
        $validate = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if($validate->fails()){
            throw new BadRequestException($validate->errors()->getMessages());
        }
        return new GetGifsBySpecificationQuery(
            $request->query('query'),
            $request->query('limit', null),
            $request->query('offset', null),
        );
    }

    private function getRules() : array
    {
        return [
            'query' => 'bail|required|min:1|max:100',
            'limit' => 'numeric|min:1|max:100',
            'offset' => 'numeric|min:0|max:100',
        ];
    }

    private function getMessages(): array {
        return [
            'query.required' => 'The query is required.',
            'query.min' => 'The query has to be 1 char min.',
            'query.max' => 'The query has to be 100 chars max.',
            'limit.numeric' => 'The limit value has to be a number.',
            'limit.min' => 'The limit value has to be min 1.',
            'limit.max' => 'The limit value has to be max 100.',
            'offset.numeric' => 'The offset value has to be a number.',
            'offset.min' => 'The offset value has to be min 1.',
            'offset.max' => 'The offset value has to be max 100.',
        ];
    }
}

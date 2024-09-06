<?php

namespace App\infrastructure\Http\enums;

class HttpCodes
{
    public const OK = 200;
    public const CREATED = 201;
    public const ASYNC = 202;
    public const NO_CONTENT = 204;
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const CONFLICT = 409;
    public const GONE = 410;
    public const UNPROCESSABLE_ENTITY = 422;
    public const INTERNAL_ERROR = 500;
    public  const UNAVAILABLE = 503;
}

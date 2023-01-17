<?php

namespace App\Exceptions\Handlers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

class Authorization
{
    /**
     * @param ValidationException $except
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function handle(AuthorizationException $except)
    {
        return fail('当前操作未被允许', 4030);
    }
}

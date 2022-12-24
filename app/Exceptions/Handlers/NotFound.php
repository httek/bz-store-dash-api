<?php

namespace App\Exceptions\Handlers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class NotFound
{
    /**
     * @param ValidationException $except
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function handle(ModelNotFoundException $except)
    {
        return fail('数据不存在', 4040);
    }
}

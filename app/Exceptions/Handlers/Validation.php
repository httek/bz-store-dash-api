<?php

namespace App\Exceptions\Handlers;

use Illuminate\Validation\ValidationException;

class Validation
{
    /**
     * @param ValidationException $except
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function handle(ValidationException $except)
    {
        return fail($except->validator->errors()->first(), 4220);
    }
}

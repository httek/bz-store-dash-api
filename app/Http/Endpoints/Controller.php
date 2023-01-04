<?php

namespace App\Http\Endpoints;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param Request|null $request
     * @return array
     */
    public function pagingInfo(Request $request = null)
    {
        $request = $request ?: \Illuminate\Support\Facades\Request::instance();

        return [$request->input('page', 1), $request->input('size', 10)];
    }

    /**
     * @param Request|null $request
     * @return int
     */
    public function getPageSize(Request $request = null): int
    {
        $request = $request ?: \Illuminate\Support\Facades\Request::instance();

        return (int) $request->input('size', 10);
    }
}

<?php

namespace App\Http\Endpoints\Auth;

use App\Http\Endpoints\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        return success($user);
    }
}

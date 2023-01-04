<?php

namespace App\Http\Endpoints;

use App\Http\Requests\LoginRequest;
use App\Services\AdminService;
use App\Services\TokenService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param LoginRequest $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        extract($request->validated());

        if (! $admin = AdminService::findByMobile($mobile)) {
            return fail('Account not found.', 4040);
        }

        if (! $admin->status) {
            return fail('Account is disabled', 4030);
        }

        if (! Hash::check($password, $admin->password)) {
            return fail('Invalid password');
        }

        $admin->token = TokenService::issue($admin);

        return success($admin);
    }
}

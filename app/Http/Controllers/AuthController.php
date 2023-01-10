<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\Login;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param Login $login
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function login(Login $login)
    {
        /** @var Admin $account */
        $account = Admin::whereMobile($login->account())
            ->first();

        if (!$account) {
            return fail('账号或密码错误 [A01]');
        }

        if ($account->disabled()) {
            return fail('您已被禁止登录');
        }

        if (! $account->validatePasswd($login->input('password'))) {
            return fail('账号或密码错误 [A02]');
        }

        $account->issueToken();

        return success($account);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function session(Request $request)
    {
        // profile
        // permissions
        // menus
        // others

        /** @var Admin $profile */
        $profile = $request->user();

        return success(compact('profile'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\Login;
use App\Models\Permission;
use App\Models\PermissionRole;
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

        if (!$account->validatePasswd($login->input('password'))) {
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
        /** @var Admin $profile */
        $profile = $request->user();
        $permissionIds = PermissionRole::where('role_id', $profile->role_id ?? 0)->pluck('permission_id')->toArray();
        $permissions = Permission::whereIn('id', $permissionIds)
            ->pluck('slug')
            ->filter()
            ->toArray();

        if ($profile->isSuperAdmin()) {
            $menus = Permission::with(['children'])
                ->whereNull('parent_id')
                ->get();
        } else {
            $menus = Permission::with(['children' => fn($query) => $query->whereIn('id', $permissionIds)])
                ->whereIn('id', $permissionIds)
                ->whereNull('parent_id')
                ->get();
        }

        return success(compact('profile', 'permissions', 'menus'));
    }
}

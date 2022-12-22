<?php

namespace App\Services;

use App\Models\Admin;

class AdminService extends Service
{
    /**
     * @param int $id
     * @return Admin|null
     */
    public static function findById(int $id): ?Admin
    {
        return Admin::find($id);
    }

    /**
     * @param string $mobile
     * @return Admin|null
     */
    public static function findByMobile(string $mobile): ?Admin
    {
        return Admin::whereMobile($mobile)->first();
    }
}

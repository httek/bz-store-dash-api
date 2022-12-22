<?php

namespace App\Providers;

use App\Services\AdminService;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) {
            $token = $request->bearerToken();
            if (! $token && $this->app->environment(['debug', 'testing', 'development'])) {
                $token = $request->input('jwt');
            }

            if ($token && ($jti = TokenService::getPayloads($token, 'jti'))) {
                return AdminService::findById($jti);
            }
        });
    }
}

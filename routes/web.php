<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');
});

$router->group(['middleware' => 'auth', 'prefix' => 'auth'], function () use ($router) {
    $router->get('profile', 'Auth\IndexController@profile');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'utils', 'namespace' => 'Utils'], function () use ($router) {
        $router->post('upload', 'UploadController@upload');
    });

    // Category
    $router->group(['prefix' => 'system', 'namespace' => 'System'], function () use ($router) {
        $router->group(['prefix' => 'categories'], function () use ($router) {
            $router->get('', 'CategoryController@index');
            $router->get('{id:[\d]+}', 'CategoryController@show');
            $router->get('select', 'CategoryController@select');
            $router->post('', 'CategoryController@store');
            $router->post('{id:[\d]+}', 'CategoryController@update');
            $router->delete('{id:[\d]+}', 'CategoryController@destroy');
        });

        $router->group(['prefix' => 'delivery/templates'], function () use ($router) {
            $router->get('', 'DeliveryTemplateController@index');
            $router->get('{id:[\d]+}', 'DeliveryTemplateController@show');
            $router->get('select', 'DeliveryTemplateController@select');
            $router->post('', 'DeliveryTemplateController@store');
            $router->post('{id:[\d]+}', 'DeliveryTemplateController@update');
            $router->delete('{id:[\d]+}', 'DeliveryTemplateController@destroy');
        });
    });
});

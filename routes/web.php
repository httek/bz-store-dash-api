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
        $router->get('categories', 'CategoryController@index');
        $router->get('categories/{id:[\d]+}', 'CategoryController@show');
        $router->get('categories/select', 'CategoryController@select');
        $router->post('categories', 'CategoryController@store');
        $router->post('categories/{id:[\d]+}', 'CategoryController@update');
        $router->delete('categories/{id:[\d]+}', 'CategoryController@destroy');
    });
});

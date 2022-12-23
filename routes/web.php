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
    // Category
    $router->group(['prefix' => 'system/categories'], function () use ($router) {
        $router->get('', 'System\CategoryController@index');
    });
});

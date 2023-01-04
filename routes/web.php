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

$router->group(['middleware' => []], function () use ($router) {
    // New
    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('', 'CategoryController@index');
        $router->get('{id:[\d]+}', 'CategoryController@show');
        $router->get('select', 'CategoryController@select');
        $router->post('', 'CategoryController@store');
        $router->post('{id:[\d]+}', 'CategoryController@update');
        $router->delete('{id:[\d]+}', 'CategoryController@destroy');
    });






    // Old
    $router->group(['prefix' => 'utils', 'namespace' => 'Utils'], function () use ($router) {
        $router->post('upload', 'UploadController@upload');
    });

    $router->group(['prefix' => 'auth', 'namespace' => 'Auth'], function () use ($router) {
        $router->group(['prefix' => 'admins'], function () use ($router) {
            $router->get('', 'AdminController@index');
        });
    });

    // Category
    $router->group(['prefix' => 'goods', 'namespace' => 'Goods'], function () use ($router) {
        $router->get('', 'GoodsController@index');
        $router->get('{id:[\d]+}', 'GoodsController@show');
        $router->post('', 'GoodsController@store');
        $router->post('{id:[\d]+}', 'GoodsController@update');
        $router->delete('{id:[\d]+}', 'GoodsController@destroy');
        $router->get('precis', 'GoodsController@precisSearch');
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

        $router->group(['prefix' => 'stores'], function () use ($router) {
            $router->get('', 'StoreController@index');
            $router->get('{id:[\d]+}', 'StoreController@show');
            $router->post('', 'StoreController@store');
            $router->post('{id:[\d]+}', 'StoreController@update');
            $router->delete('{id:[\d]+}', 'StoreController@destroy');
            $router->get('precis', 'StoreController@precisSearch');
            $router->get('select', 'StoreController@select');
        });

        $router->group(['prefix' => 'brands'], function () use ($router) {
            $router->get('', 'BrandController@index');
            $router->get('{id:[\d]+}', 'BrandController@show');
            $router->post('', 'BrandController@store');
            $router->post('{id:[\d]+}', 'BrandController@update');
            $router->delete('{id:[\d]+}', 'BrandController@destroy');
            $router->get('precis', 'BrandController@precisSearch');
            $router->get('select', 'BrandController@select');
        });

        $router->group(['prefix' => 'products'], function () use ($router) {
            $router->get('', 'ProductController@index');
            $router->get('{id:[\d]+}', 'ProductController@show');
            $router->post('', 'ProductController@store');
            $router->post('{id:[\d]+}', 'ProductController@update');
            $router->delete('{id:[\d]+}', 'ProductController@destroy');
            $router->get('precis', 'ProductController@precisSearch');
            $router->get('select', 'ProductController@select');
        });
    });
});

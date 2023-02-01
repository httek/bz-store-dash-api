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

// Auth
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('session', 'AuthController@session');
    });
});

$router->group(['middleware' => null], function () use ($router) {
    // Upload
    $router->post('upload', 'UploadController@upload');

    // Roles
    $router->group(['prefix' => 'roles'], function () use ($router) {
        $router->get('', 'RoleController@index');
        $router->get('{id:[\d]+}', 'RoleController@show');
        $router->get('precise', 'RoleController@precise');
        $router->get('select', 'RoleController@select');
        $router->post('', 'RoleController@store');
        $router->post('{id:[\d]+}/permissions', 'RoleController@attachPermission');
        $router->post('{id:[\d]+}', 'RoleController@update');
        $router->delete('{id:[\d]+}', 'RoleController@destroy');
    });

    // Permissions
    $router->group(['prefix' => 'permissions'], function () use ($router) {
        $router->get('', 'PermissionController@index');
        $router->get('{id:[\d]+}', 'PermissionController@show');
        $router->get('precise', 'PermissionController@precise');
        $router->post('', 'PermissionController@store');
        $router->post('{id:[\d]+}', 'PermissionController@update');
        $router->delete('{id:[\d]+}', 'PermissionController@destroy');
    });

    // Admins
    $router->group(['prefix' => 'admins'], function () use ($router) {
        $router->get('', 'AdminController@index');
        $router->get('{id:[\d]+}', 'AdminController@show');
        $router->get('select', 'AdminController@select');
        $router->get('precise', 'AdminController@precise');
        $router->post('', 'AdminController@store');
        $router->post('{id:[\d]+}', 'AdminController@update');
        $router->delete('{id:[\d]+}', 'AdminController@destroy');
    });

    // Category
    $router->group(['prefix' => 'tags'], function () use ($router) {
        $router->get('', 'TagController@index');
        $router->get('{id:[\d]+}', 'TagController@show');
        $router->get('select', 'TagController@select');
        $router->get('precise', 'TagController@precise');
        $router->post('', 'TagController@store');
        $router->post('{id:[\d]+}', 'TagController@update');
        $router->delete('{id:[\d]+}', 'TagController@destroy');
    });

    // Category
    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('', 'CategoryController@index');
        $router->get('{id:[\d]+}', 'CategoryController@show');
        $router->get('select', 'CategoryController@select');
        $router->get('precise', 'CategoryController@precise');
        $router->post('', 'CategoryController@store');
        $router->post('{id:[\d]+}', 'CategoryController@update');
        $router->delete('{id:[\d]+}', 'CategoryController@destroy');
    });

    // Brand
    $router->group(['prefix' => 'brands'], function () use ($router) {
        $router->get('', 'BrandController@index');
        $router->get('{id:[\d]+}', 'BrandController@show');
        $router->get('select', 'BrandController@select');
        $router->get('precise', 'BrandController@precise');
        $router->post('', 'BrandController@store');
        $router->post('{id:[\d]+}', 'BrandController@update');
        $router->delete('{id:[\d]+}', 'BrandController@destroy');
    });

    // Store
    $router->group(['prefix' => 'stores'], function () use ($router) {
        $router->get('', 'StoreController@index');
        $router->get('{id:[\d]+}', 'StoreController@show');
        $router->get('select', 'StoreController@select');
        $router->get('precise', 'StoreController@precise');
        $router->post('', 'StoreController@store');
        $router->post('{id:[\d]+}', 'StoreController@update');
        $router->delete('{id:[\d]+}', 'StoreController@destroy');
    });

    // Delivery
    $router->group(['prefix' => 'deliveries'], function () use ($router) {
        $router->get('', 'DeliveryController@index');
        $router->get('{id:[\d]+}', 'DeliveryController@show');
        $router->get('select', 'DeliveryController@select');
        $router->get('precise', 'DeliveryController@precise');
        $router->post('', 'DeliveryController@store');
        $router->post('{id:[\d]+}', 'DeliveryController@update');
        $router->delete('{id:[\d]+}', 'DeliveryController@destroy');
    });

    // Product
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('', 'ProductController@index');
        $router->get('{id:[\d]+}', 'ProductController@show');
        $router->get('select', 'ProductController@select');
        $router->get('precise', 'ProductController@precise');
        $router->post('', 'ProductController@store');
        $router->post('{id:[\d]+}', 'ProductController@update');
        $router->delete('{id:[\d]+}', 'ProductController@destroy');
    });

    // Goods
    $router->group(['prefix' => 'goods'], function () use ($router) {
        $router->get('', 'GoodsController@index');
        $router->get('{id:[\d]+}', 'GoodsController@show');
        $router->get('select', 'GoodsController@select');
        $router->get('precise', 'GoodsController@precise');
        $router->post('', 'GoodsController@store');
        $router->post('{id:[\d]+}', 'GoodsController@update');
        $router->delete('{id:[\d]+}', 'GoodsController@destroy');
    });

    // Payments
    $router->group(['prefix' => 'payments'], function () use ($router) {
        $router->get('', 'PaymentController@index');
        $router->get('{id:[\d]+}', 'PaymentController@show');
        $router->get('precise', 'PaymentController@precise');
        $router->post('', 'PaymentController@store');
        $router->post('{id:[\d]+}', 'PaymentController@update');
        $router->delete('{id:[\d]+}', 'PaymentController@destroy');
    });

    // Block
    $router->group(['prefix' => 'blocks'], function () use ($router) {
        $router->get('', 'BlockController@index');
        $router->get('{id:[\d]+}', 'BlockController@show');
        $router->get('precise', 'BlockController@precise');
        $router->post('', 'BlockController@store');
        $router->post('{id:[\d]+}', 'BlockController@update');
        $router->delete('{id:[\d]+}', 'BlockController@destroy');
    });

    // Swiper
    $router->group(['prefix' => 'swipers'], function () use ($router) {
        $router->get('', 'SwiperController@index');
        $router->get('{id:[\d]+}', 'SwiperController@show');
        $router->get('precise', 'SwiperController@precise');
        $router->post('', 'SwiperController@store');
        $router->post('{id:[\d]+}', 'SwiperController@update');
        $router->delete('{id:[\d]+}', 'SwiperController@destroy');
    });

    // Swiper
    $router->group(['prefix' => 'configs'], function () use ($router) {
        $router->get('', 'ConfigController@index');
        $router->get('{id:[\d]+}', 'ConfigController@show');
        $router->get('precise', 'ConfigController@precise');
        $router->post('', 'ConfigController@store');
        $router->post('{id:[\d]+}', 'ConfigController@update');
        $router->delete('{id:[\d]+}', 'ConfigController@destroy');
    });

});

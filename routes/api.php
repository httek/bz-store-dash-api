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

// Upload
$router->post('upload', 'UploadController@upload');

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

// Product
$router->group(['prefix' => 'products'], function () use ($router) {
    $router->get('', 'ProductController@index');
    $router->get('{id:[\d]+}', 'ProductController@show');
    $router->get('precise', 'ProductController@precise');
    $router->post('', 'ProductController@store');
    $router->post('{id:[\d]+}', 'ProductController@update');
    $router->delete('{id:[\d]+}', 'ProductController@destroy');
});

// Goods
$router->group(['prefix' => 'goods'], function () use ($router) {
    $router->get('', 'GoodsController@index');
    $router->get('{id:[\d]+}', 'GoodsController@show');
    $router->get('precise', 'GoodsController@precise');
    $router->post('', 'GoodsController@store');
    $router->post('{id:[\d]+}', 'GoodsController@update');
    $router->delete('{id:[\d]+}', 'GoodsController@destroy');
});

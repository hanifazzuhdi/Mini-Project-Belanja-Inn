<?php

use Illuminate\Support\Facades\Route;

// Route Auth
Route::post('/login', 'Api\\AuthController@login');
Route::post('/register', 'Api\\AuthController@register');

// Route Public
Route::group(['prefix' => 'public'], function () {
    Route::get('/', 'Api\\PublicController@index');
    Route::get('/{id}', 'Api\\PublicController@show');
    Route::get('/category/{category_id}', 'Api\\PublicController@showCategory');
    Route::post('/search', 'Api\\PublicController@search');
});

Route::get('/get_shop/{id}', 'Api\\ShopController@index');

// Middleware Jwt
Route::group(['middleware' => ['jwt.verify']], function () {

    Route::post('/logout', 'Api\AuthController@logout');

    // Route User
    Route::get('/get_user', 'Api\\UserController@getUserAuth');
    Route::put('/update_user', 'Api\\UserController@update');
    Route::put('/update_password', 'Api\\UserController@updatePassword');

    // Route Shop
    Route::post('/store_shop', 'Api\\ShopController@store');
    Route::put('/update_shop', 'Api\\ShopController@update');

    // Route Crud Seller
    Route::post('/store_product', 'Api\\SellerController@store');
    Route::put('/update_product/{id}', 'Api\\SellerController@update');
    Route::delete('/destroy_product/{id}', 'Api\SellerController@destroy');

    //Route order
    Route::post('/order_product/{id}', 'Api\\OrderController@order');
    Route::get('/carts', 'Api\\OrderController@carts');
    Route::delete('/delete_cart/{id}', 'Api\\OrderController@delete');

    // Route transaksi
    Route::get('/getCheckout', 'Api\\TransactionController@getCheckout');
    Route::post('/checkout', 'Api\TransactionController@checkout');
    Route::get('/history', 'Api\TransactionController@history');
    Route::get('/getHistory/{id}', 'Api\TransactionController@getHistory');

    // Route coba fitur
    Route::get('/coba', 'Api\TransactionController@coba');
});

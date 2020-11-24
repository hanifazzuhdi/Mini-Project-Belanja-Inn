<?php

use Illuminate\Support\Facades\Route;

// Route Auth
Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');

// Route Public
Route::group(['prefix' => 'public'], function () {
    Route::get('/', 'Api\PublicController@index');
    Route::get('/{id}', 'Api\PublicController@show');
    Route::get('/category/{category_id}', 'Api\PublicController@showCategory');
    Route::post('/search', 'Api\PublicController@search');
    Route::post('/filter_search', 'Api\PublicController@filterSearch');
});

Route::get('/get_shop/{id}', 'Api\ShopController@index');
// Route::get('')

// Middleware Jwt
Route::group(['middleware' => ['jwt.verify']], function () {

    Route::post('/logout', 'Api\AuthController@logout');

    // Route User
    Route::get('/get_user', 'Api\UserController@getUserAuth');
    Route::put('/update_user', 'Api\UserController@update');
    Route::put('/update_password', 'Api\UserController@updatePassword');

    // Route Shop
    Route::post('/store_shop', 'Api\ShopController@store');
    Route::put('/update_shop', 'Api\ShopController@update');

    // Route Crud Seller
    Route::post('/store_product', 'Api\SellerController@store');
    Route::put('/update_product/{id}', 'Api\SellerController@update');
    Route::delete('/destroy_product/{id}', 'Api\SellerController@destroy');

    //Route order
    Route::get('/carts', 'Api\OrderController@carts');
    Route::post('/order_product/{id}', 'Api\OrderController@order');
    Route::put('/update_cart/{id}', 'Api\OrderController@updateCart');
    Route::delete('/delete_cart/{id}', 'Api\OrderController@delete');

    // Route Checkout
    Route::get('/getCheckout', 'Api\CheckoutController@getCheckout');
    Route::post('/checkout', 'Api\CheckoutController@checkout');

    // Route Transaction

    // Buyer
    Route::get('/waitConfirm', 'Api\TransactionController@waitConfirm');
    Route::get('/sending', 'Api\TransactionController@sending');
    Route::get('/history', 'Api\TransactionController@history');
    Route::post('/confirmSent/{id}', 'Api\TransactionController@confirmSent');

    // Seller
    Route::get('/confirmation', 'Api\TransactionController@confirmation');
    Route::get('/shopSending', 'Api\TransactionController@shopSending');
    Route::get('/soldHistory', 'Api\TransactionController@soldHistory');
    Route::post('/setConfirmation/{id}', 'Api\TransactionController@setConfirmation');
});

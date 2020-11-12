<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

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

Route::get('/get_shop/{id}', 'Api\\ShopController@shop')->name('get_shop');

// Middleware Jwt
Route::group(['middleware' => ['jwt.verify']], function () {
    // Route User
    Route::get('/get_user', 'Api\\UserController@getUserAuth')->name('get_user');
    Route::post('/update_user/{id}', 'Api\\UserController@updateUser');
    Route::post('/logout', 'Api\AuthController@logout');

    // Route Shop
    Route::post('/store_shop', 'Api\\ShopController@storeShop')->name('store_shop');

    // Route crud Seller
    Route::post('store/product', 'Api\\SellerController@storeProduct')->name('store_product');
    Route::put('update/product/{id}', 'Api\\SellerController@updateProduct')->name('update_product');
    Route::delete('/destroy/product/{id}', 'Api\SellerController@destroy')->name('destroy');
});

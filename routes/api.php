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


// middleware jwt
Route::group(['middleware' => ['jwt.verify']], function () {
    // Route Shop
    Route::get('/get_shop/{id}', 'Api\\ShopController@shop')->name('get_shop');
    Route::post('/store_shop', 'Api\\ShopController@storeShop')->name('store_shop');

    // Route crud Seller
    Route::post('/store_product', 'Api\SellerController@storeProduct')->name('store_product');
    Route::put('/update_product/{id}', 'Api\SellerController@updateProduct')->name('update_product');
});

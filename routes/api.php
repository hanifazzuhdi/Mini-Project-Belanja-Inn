<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Auth
Route::post('/login', 'Api\\AuthController@login');
Route::post('/register', 'Api\\AuthController@register');


Route::group(['middleware' => ['jwt.verify']], function () {
    // Route Seller
    Route::get('/shop', 'Api\\SellerController@shop');
    Route::post('/create_shop', 'Api\\SellerController@createShop');
    Route::post('/store_product', 'Api\SellerController@store');
});

<?php

use Illuminate\Http\Request;

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

Route::get('editCategory', 'Admin\CategoryController@getCategory');
Route::get('showProduct', 'Admin\ProductController@show');
Route::get('getProduct', 'FrontController@getProduct');
Route::get('city', 'TransactionController@getCity');
Route::get('district', 'TransactionController@getDistrict');

<?php


// Front
Route::get('/', 'FrontController@index')->name('front.index');
Route::get('/produk', 'FrontController@product')->name('front.product');
Route::get('category/{slug}', 'FrontController@categoryProduct');
Route::get('produk/{slug}', 'FrontController@show');


Route::group(['prefix' => 'cart'], function () {
    Route::get('/', 'TransactionController@listCart')->name("front.cart_list");
    Route::post('/', 'TransactionController@addToCart')->name('front.cart');
    Route::put('/', 'TransactionController@updateCart')->name('front.update_cart');
    Route::get('/{cart}', 'TransactionController@deleteCart')->name('front.delete_cart');
});

Route::group(['prefix' => 'checkout'], function () {
    Route::get('/', 'TransactionController@checkout')->name('front.checkout');
    Route::post('/', 'TransactionController@prosesCheckout')->name('front.prosesCheckout');
    Route::get('/{invoice}', 'TransactionController@checkoutFinish')->name('front.finish_checkout');
});
// EndFront


Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['auth', 'CheckRole:customer']], function () { });

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'CheckRole:admin']], function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::resource('/product', 'Admin\ProductController');

    Route::resource('/category', 'Admin\CategoryController')->except(['create', 'show', 'edit']);
});

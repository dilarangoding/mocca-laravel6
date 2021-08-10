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

// Customer
Route::group(['middleware' => ['auth', 'CheckRole:customer']], function () {
    Route::get('/dashboard', 'DashboardController@dashboard')->name("customer.dashboard");

    Route::get('/pesanan', 'OrderController@index')->name('customer.order');
    Route::get('/pesanan/{invoice}', 'OrderController@detailOrder')->name('customer.detail_order');

    Route::get('/payment', 'OrderController@payment')->name('customer.payment');
    Route::post('/payment', 'OrderController@paymentStore')->name("customer.payment_store");

    Route::get('setting', 'FrontController@settingForm')->name('customer.settingForm');
    Route::post('setting', 'FrontController@customerUpdateProfile')->name('customer.setting');
});




// Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'CheckRole:admin']], function () {

    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::resource('/product', 'Admin\ProductController');

    Route::resource('/category', 'Admin\CategoryController')->except(['create', 'show', 'edit']);
});

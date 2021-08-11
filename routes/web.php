<?php


// Front
Route::get('/', 'FrontController@index')->name('front.index');

Route::get('/produk', 'FrontController@product')->name('front.product');
Route::get('category/{slug}', 'FrontController@categoryProduct');
Route::get('produk/{slug}', 'FrontController@show');



Auth::routes(['verify' => true]);

Route::group(['prefix' => 'cart', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', 'TransactionController@listCart')->name("front.cart_list");
    Route::post('/', 'TransactionController@addToCart')->name('front.cart');
    Route::put('/', 'TransactionController@updateCart')->name('front.update_cart');
    Route::get('/{cart}', 'TransactionController@deleteCart')->name('front.delete_cart');
});

Route::group(['prefix' => 'checkout', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', 'TransactionController@checkout')->name('front.checkout');
    Route::post('/', 'TransactionController@prosesCheckout')->name('front.prosesCheckout');
    Route::get('/{invoice}', 'TransactionController@checkoutFinish')->name('front.finish_checkout');
});
// EndFront



Route::get('logout', 'Auth\LoginController@logout');

// Customer
Route::group(['middleware' => ['auth', 'CheckRole:customer', 'verified']], function () {
    Route::get('/dashboard', 'DashboardController@dashboard')->name("customer.dashboard");

    Route::get('/pesanan', 'OrderController@index')->name('customer.order');
    Route::get('/pesanan/{invoice}', 'OrderController@detailOrder')->name('customer.detail_order');
    Route::post('/pesanan', 'OrderController@acceptOrder')->name('customer.order_accept');
    Route::get('/pesanan/return/{invoice}', 'OrderController@returnForm')->name('customer.order_return');
    Route::put('/pesanan/return{id}', 'OrderController@proccessReturn')->name('customer.return');

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

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', 'Admin\OrderController@index')->name('orders.index');
        Route::post('/', 'Admin\OrderController@shippingOrder')->name('orders.tracking_number');
        Route::get('/{invoice}', 'Admin\OrderController@detail')->name('orders.detail');
        Route::get('/accept_payment/{id}', 'Admin\OrderController@acceptPayment');
        Route::delete('/{id}', 'Admin\OrderController@destroy')->name('orders.destroy');
        Route::get('/return/{invoice}', 'Admin\OrderController@return')->name('orders.return');
        Route::post('/return', 'Admin\OrderController@approveReturn')->name('orders.approve_return');
    });

    Route::get('/customers', 'Admin\CustomerController@index')->name('customers.index');
    Route::delete('/customers/{id}', 'Admin\CustomerController@destroy')->name('customers.destroy');

    Route::get('laporan', 'HomeController@orderReport')->name('report.index');
    Route::get('laporan/pdf/{daterange}', 'HomeController@orderReportPdf')->name('report.order_pdf');
});

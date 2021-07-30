<?php



Route::get('/', 'FrontController@index')->name('front.index');
Route::get('/produk', 'FrontController@product')->name('front.product');
Route::get('category/{slug}', 'FrontController@categoryProduct');
Route::get('produk/{slug}', 'FrontController@show');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['auth', 'CheckRole:customer']], function () { });

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'CheckRole:admin']], function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::resource('/product', 'Admin\ProductController');

    Route::resource('/category', 'Admin\CategoryController')->except(['create', 'show', 'edit']);
});

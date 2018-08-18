<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');
Route::get('/usps', 'HomeController@uspsTest');

Route::get('/energy-saving-tips', 'HomeController@energy')->name('energy-saving-tips');

Route::get('/search', 'HomeController@search')->name('search');

Route::post('/add-to-cart', 'ProductController@addToCart')->name('add_to_cart');

Route::patch('/update-cart', 'ProductController@updateCart')->name('update_cart');

Route::post('/remove-from-cart', 'ProductController@removeFromCart')->name('remove_from_cart');

Route::get('/cart', 'ProductController@cart')->name('cart');

Route::post('/apply-coupon-code', 'ProductController@applyCouponCode')->name('apply_coupon_code');

Route::get('/check-out', 'ProductController@checkOut')->name('check_out');

Route::post('/check-out', 'ProductController@postCheckOut')->name('post_check_out');

Route::get('/shipping', 'ProductController@shipping')->name('shipping');

Route::post('/shipping', 'ProductController@postShipping')->name('post_shipping');

Route::get('/pay', 'ProductController@pay')->name('pay');

Route::post('/pay', 'ProductController@postPay')->name('post_pay');

Route::get('/thanks/{order_id}', 'ProductController@thanks')->name('thanks');

Route::resource('/products', 'ProductController');

Route::resource('/product-types', 'ProductTypeController')->middleware('admin');

Route::resource('/coupon-codes', 'CouponCodeController')->middleware('admin');

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/admin', 'HomeController@admin')->name('admin')->middleware('admin');

Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

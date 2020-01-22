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

Route::get('/set-locale', 'LocaleController@setLocale');

Route::middleware(['localizebybrowser'])->group(function() {
    
    // Admin Routes
    Route::get('/pending', 'AdminController@pending');
    Route::get('/shipped', 'AdminController@shipped');
    Route::get('/manage', 'AdminController@manage');

    Route::post('/create', 'AdminController@create');
    Route::get('/create', 'AdminController@goHome');
    Route::get('/stock', 'AdminController@stock');
    Route::get('/sent/{id}', 'AdminController@sent');

    Route::get('/shipment/delete', 'AdminController@delete');
    Route::get('/product/delete/{id}', 'AdminController@productDelete');

    Route::get('/settings', 'SettingsController@index');
    Route::post('/settings/update/basic-info', 'SettingsController@updateBasicInfo');

    Route::post('/country/store', 'CountryController@store');
    Route::delete('/country/delete/{id}', 'CountryController@delete');
});

Route::middleware(['notregistered','localizebybrowser'])->group(function() {

    // Public Routes
    Route::get('/bluelogin', 'Auth\Admin\LoginController@index')->name('admin.login.index');
    Route::post('/bluelogin', 'Auth\Admin\LoginController@login')->name('admin.login.login');
    Route::get('/bluelogin/logout', 'Auth\Admin\LoginController@logout')->name('admin.login.logout');


    Route::get('/', 'IndexController@index')->name('index');
    Route::post('/payment', 'ShippingFormController@validateShippingForm');
    Route::post('/checkpayment', 'PaymentController@check');
    Route::get('/payment/confirmed', 'PaymentController@confirmed');

    Route::get('/js/lang.js','LocaleController@localizeForJs')->name('locale.localizeForJs');
});

/* Route::get('/', function() {
    return "hi";
}); */
Route::post('/bluelogin/register', 'Auth\Admin\RegisterController@store')->name('admin.register.store');
Route::get('/bluelogin/register', 'Auth\Admin\RegisterController@index')->name('admin.register.index');


// User routes

Route::get('/dashboard', 'UserController@index')->name('user.index');
Route::post('/user/login', 'Auth\LoginController@login')->name('user.login.login');
Route::get('/user/logout', 'Auth\LoginController@logout')->name('user.login.logout');
Route::post('/user/register','UserController@store')->name('user.store');

Route::get('/success', function() {
    return view('storefront.confirmed');
});

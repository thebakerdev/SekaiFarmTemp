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
    Route::get('/pending', 'AdminController@pending')->name('admin.pending');
    Route::get('/shipped', 'AdminController@shipped')->name('admin.shipped');
    Route::get('/manage', 'AdminController@manage')->name('admin.manage');
    Route::get('/users', 'AdminController@users')->name('admin.users');

    // Product Routes
    Route::post('/product/store', 'ProductController@store')->name('product.store');
    Route::delete('/product/delete/{id}', 'ProductController@destroy')->name('product.destroy');
    Route::put('/product/adjust-stock', 'ProductController@adjustStock')->name('product.adjustStock');

    // Shipment Routes
    Route::put('/shipment/sent', 'ShipmentController@sent')->name('shipment.sent');
    Route::delete('/shipment/delete', 'ShipmentController@destroy')->name('shipment.destroy');

    // Route::post('/create', 'AdminController@create');
    //Route::get('/create', 'AdminController@goHome');
    //Route::get('/stock', 'AdminController@stock');
    //Route::get('/sent/{id}', 'AdminController@sent');

    //Route::get('/shipment/delete', 'AdminController@delete');
   // Route::get('/product/delete/{id}', 'AdminController@productDelete');

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
Route::get('/orders', 'UserController@index')->name('user.index');
Route::post('/user/login', 'Auth\LoginController@login')->name('user.login.login');
Route::get('/user/logout', 'Auth\LoginController@logout')->name('user.login.logout');
Route::post('/user/register','UserController@store')->name('user.store');
Route::post('/user/register/validate','UserController@validateData')->name('user.validate');
Route::post('/user/password/link','Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.link');
Route::get('/user/password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/user/password/reset','Auth\ResetPasswordController@reset')->name('password.update');


Route::get('/ls',function(){
    return 'wala';
})->name('login');


Route::get('/success', function() {
    return view('storefront.confirmed');
});

Route::get('mail', function () {

    $user = \App\user::first();
    return (new \App\Notifications\ResetPasswordNotification('token'))
                ->toMail($user);
});

/* Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home'); */

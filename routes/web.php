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
    Route::put('/product/update', 'ProductController@update')->name('product.update');
    Route::put('/product/adjust-stock', 'ProductController@adjustStock')->name('product.adjustStock');
    Route::delete('/product/delete/{id}', 'ProductController@destroy')->name('product.destroy');

    // Shipment Routes
    Route::put('/shipment/sent', 'ShipmentController@sent')->name('shipment.sent');
    Route::delete('/shipment/delete', 'ShipmentController@destroy')->name('shipment.destroy');
    Route::put('/shipment/delivered', 'ShipmentController@setDelivered')->name('shipment.setDelivered');
    

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
    Route::get('/success', 'IndexController@success')->name('success');
    Route::get('/js/lang.js','LocaleController@localizeForJs')->name('locale.localizeForJs');
});

/* Route::get('/', function() {
    return "hi";
}); */
Route::post('/bluelogin/register', 'Auth\Admin\RegisterController@store')->name('admin.register.store');
Route::get('/bluelogin/register', 'Auth\Admin\RegisterController@index')->name('admin.register.index');


// User routes
Route::get('/orders', 'UserOrderController@index')->name('user.orders.index');

Route::get('/address', 'AddressController@index')->name('user.address.index');
Route::post('/address/store', 'AddressController@store')->name('user.address.store');
Route::put('/address/update', 'AddressController@update')->name('user.address.update');
Route::put('/address/set-default', 'AddressController@setDefault')->name('user.address.setDefault');
Route::delete('/address/delete', 'AddressController@destroy')->name('user.address.destroy');

Route::get('/account', 'UserController@index')->name('user.account.index');
Route::put('/account/update', 'UserController@update')->name('user.account.update');
Route::put('/account/change-password', 'UserController@changePassword')->name('user.account.changePassword');

Route::get('/subscription', 'SubscriptionController@index')->name('user.subscription.index');
Route::post('/subscription/cancel', 'SubscriptionController@cancel')->name('user.subscription.cancel');
Route::post('/subscription/resume', 'SubscriptionController@resume')->name('user.subscription.resume');

Route::post('/user/login', 'Auth\LoginController@login')->name('user.login.login');
Route::get('/user/logout', 'Auth\LoginController@logout')->name('user.login.logout');
Route::post('/user/register','UserController@store')->name('user.store');
Route::post('/user/register/validate','UserController@validateData')->name('user.validate');
Route::post('/user/password/link','Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.link');
Route::get('/user/password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/user/password/reset','Auth\ResetPasswordController@reset')->name('password.update');

Route::post('stripe/webhook', 'StripeWebhookController@handleWebhook')->name('stripe.webhook');


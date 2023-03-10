
<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){





Route::group(['namespace'=>'Dashboard', 'middleware'=>'auth:admin', 'prefix'=>'admin'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');

    Route::group(['prefix'=>'settings'], function (){
       Route::get('shipping-methods/{type}', 'SettingController@editShippingMethods')->name('edit.shippings.methods');
       Route::put('shipping-methods/{id}', 'SettingController@updateShippingMethods')->name('update.shippings.methods');

    });

    Route::group(['prefix'=>'profile'], function (){
        Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
        Route::put('update/', 'SettingController@updateProfile')->name('update.profile');
    });

});


Route::group(['namespace'=>'Dashboard' , 'middleware'=>'guest:admin' , 'prefix'=>'admin'], function () {

    Route::get('/login', 'AuthController@login')->name('admin.login');

    Route::post('login/store', 'AuthController@postLogin')->name('login.store');
});



});

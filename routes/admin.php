
<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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

    Route::group(['prefix'=>'settings'], function (){

       Route::get('shipping-methods/{type}', 'SettingController@editShippingMethods')->name('edit.shippings.methods');
       Route::post('shipping-methods/{id}', 'SettingController@updateShippingMethods')->name('update.shippings.methods');


    });

});


Route::group(['namespace'=>'Dashboard' , 'middleware'=>'guest:admin','prefix'=>'admin'], function () {

    Route::get('/login', 'AuthController@login')->name('admin.login');

    Route::post('login/store', 'AuthController@postLogin')->name('login.store');
});



});

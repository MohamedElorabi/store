
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

Route::group(['namespace'=>'Dashboard', 'middleware'=>'auth:admin', 'prefix'=>'admin'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

});


Route::group(['namespace'=>'Dashboard' , 'middleware'=>'guest:admin','prefix'=>'admin'], function () {

    Route::get('/login', 'AuthController@login')->name('admin.login');

    Route::post('login/store', 'AuthController@postLogin')->name('login.store');
});



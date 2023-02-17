
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

    Route::get('/home', 'HomeController@index')->name('admin.home');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');


    #############################################  settings route    ###########################################
    Route::group(['prefix'=>'settings'], function (){
       Route::get('shipping-methods/{type}', 'SettingController@editShippingMethods')->name('edit.shippings.methods');
       Route::put('shipping-methods/{id}', 'SettingController@updateShippingMethods')->name('update.shippings.methods');

    });
    ############################################# end settings route    ###########################################

    ############################################## profile route         ##########################################
    Route::group(['prefix'=>'profile'], function (){
        Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
        Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
    });
    ############################################ end profile route #################################################

    ################################################ categories routes################################################
    Route::group(['prefix'=>'main_categories'], function (){
        Route::get('/', 'MainCategoriesController@index')->name('admin.maincategories');
        Route::get('create', 'MainCategoriesController@create')->name('admin.maincategories.create');
        Route::post('store', 'MainCategoriesController@store')->name('admin.maincategories.store');
        Route::get('edit/{id}', 'MainCategoriesController@edit')->name('admin.maincategories.edit');
        Route::post('update/{id}', 'MainCategoriesController@update')->name('admin.maincategories.update');
        Route::get('delete/{id}', 'MainCategoriesController@destroy')->name('admin.maincategories.delete');

    });
    ################################################ end categories   ###############################################



    ################################################ brands routes################################################
    Route::group(['prefix'=>'brands'], function (){
        Route::get('/', 'BrandsController@index')->name('admin.brands');
        Route::get('create', 'BrandsController@create')->name('admin.brands.create');
        Route::post('store', 'BrandsController@store')->name('admin.brands.store');
        Route::get('edit/{id}', 'BrandsController@edit')->name('admin.brands.edit');
        Route::post('update/{id}', 'BrandsController@update')->name('admin.brands.update');
        Route::get('delete/{id}', 'BrandsController@destroy')->name('admin.brands.delete');

    });
    ################################################ end brands   ###############################################

    ################################################ tags routes################################################
    Route::group(['prefix'=>'tags'], function (){
        Route::get('/', 'TagsController@index')->name('admin.tags');
        Route::get('create', 'TagsController@create')->name('admin.tags.create');
        Route::post('store', 'TagsController@store')->name('admin.tags.store');
        Route::get('edit/{id}', 'TagsController@edit')->name('admin.tags.edit');
        Route::post('update/{id}', 'TagsController@update')->name('admin.tags.update');
        Route::get('delete/{id}', 'TagsController@destroy')->name('admin.tags.delete');

    });
    ################################################ end tags   ###############################################
});


Route::group(['namespace'=>'Dashboard' , 'middleware'=>'guest:admin' , 'prefix'=>'admin'], function () {

    Route::get('/login', 'AuthController@login')->name('admin.login');

    Route::post('login/store', 'AuthController@postLogin')->name('login.store');
});



});

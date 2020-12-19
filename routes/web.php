<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes([
    'register' => false
]);


Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'profile', 'namespace' => 'Admin'], function() {
        Route::get('/', 'ProfileController@index')->name('profile');
        Route::post('/', 'ProfileController@update')->name('profile.update');
    });

    Route::group(['prefix' => 'data-lokasi'], function () {
        Route::group(['prefix' => 'country', 'namespace' => 'Admin'], function() {
            Route::get('/', 'CountryController@index')->name('country');
            Route::post('/', 'CountryController@create')->name('country.add');
            Route::post('/delete', 'CountryController@delete')->name('country.delete');
            Route::post('/{id}', 'CountryController@update')->name('country.update');
            Route::get('/data', 'CountryController@data')->name('country.data');
            Route::get('/data/select', 'CountryController@dataSelect')->name('country.data.select');
        });

        Route::group(['prefix' => 'region', 'namespace' => 'Admin'], function() {
            Route::get('/', 'RegionController@index')->name('region');
            Route::post('/', 'RegionController@create')->name('region.add');
            Route::post('/delete', 'RegionController@delete')->name('region.delete');
            Route::post('/{id}', 'RegionController@update')->name('region.update');
            Route::get('/data', 'RegionController@data')->name('region.data');
        });

        Route::group(['prefix' => 'city', 'namespace' => 'Admin'], function() {
            Route::get('/', 'CityController@index')->name('city');
            Route::post('/', 'CityController@create')->name('city.add');
            Route::post('/delete', 'CityController@delete')->name('city.delete');
            Route::post('/{id}', 'CityController@update')->name('city.update');
            Route::get('/data', 'CityController@data')->name('city.data');
        });

        Route::group(['prefix' => 'branch', 'namespace' => 'Admin'], function() {
            Route::get('/', 'BranchController@index')->name('branch');
            Route::get('/data', 'BranchController@data')->name('branch.data');
        });
    });

});

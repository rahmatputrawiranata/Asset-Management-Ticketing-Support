<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public api

Route::group(['namespace' => 'Api'], function() {
    Route::group(['prefix' => 'data-lokasi'], function () {
        Route::group(['prefix' => 'country'], function () {
            Route::get('/all', 'CountryController@all');
            Route::get('/select-data', 'CountryController@selectDataFormat');
        });

        Route::group(['prefix' => 'province'], function () {
            Route::get('/all/{id}', 'ProvinceController@all');
            Route::get('/select-data/{id}', 'ProvinceController@selectDataFormat');
        });

        Route::group(['prefix' => 'city'], function () {
            Route::get('/all/{id}', 'CityController@all');
            Route::get('/select-data', 'CityController@allData');
            Route::get('/select-data/{id}', 'CityController@selectDataFormat');
        });

        Route::group(['prefix' => 'branch'], function() {
            Route::get('/all/{id}', 'BranchController@allData');
        });
    });
});

Route::group(['namespace' => 'Api\Customer', 'prefix' => 'customer'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
    });

    Route::group(['middleware' => 'auth:customer'], function() {
        //Profile Customer
        Route::group(['prefix' => 'profile'], function() {
            Route::get('/', 'ProfileController@index');
            Route::post('/update', 'ProfileController@update');
            Route::post('/update-password', 'ProfileController@updatePassword');
        });
    });
});

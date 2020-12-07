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
Route::group(['namespace' => 'Api'], function () {
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
            Route::get('/select-data/{id}', 'CityController@selectDataFormat');
        });


    });
});

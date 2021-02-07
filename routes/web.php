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

    Route::group(['prefix' => 'customer', 'namespace' => 'Admin'], function() {
        Route::get('/', 'CustomerController@index')->name('customer');
        Route::get('/data', 'CustomerController@data')->name('customer.data');
    });

    Route::group(['prefix' => 'worker', 'namespace' => 'Admin'], function() {
        Route::get('/', 'WorkerController@index')->name('worker');
        Route::post('/', 'WorkerController@store')->name('worker.store');
        Route::get('/data', 'WorkerController@data')->name('worker.data');
        Route::post('/delete', 'WorkerController@delete')->name('worker.delete');
        Route::post('/{id}', 'WorkerController@update')->name('worker.update');
    });

    Route::group(['prefix' => 'device', 'namespace' => 'Admin'], function () {
        Route::get('/', 'DeviceController@index')->name('device');
        Route::post('/', 'DeviceController@create')->name('device.create');
        Route::post('/delete', 'DeviceController@delete')->name('device.delete');
        Route::post('/{id}', 'DeviceController@update')->name('device.update');
        Route::get('/data', 'DeviceController@data')->name('device.data');

    });

    Route::group(['prefix' => 'severity', 'namespace' => 'Admin'], function() {
        Route::get('/', 'SeverityController@index')->name('severity');
        Route::post('/', 'SeverityController@create')->name('severity.add');
        Route::post('/delete', 'SeverityController@delete')->name('severity.delete');
        Route::get('/data', 'SeverityController@data')->name('severity.data');
        Route::get('/data/select', 'SeverityController@selectDataFormat')->name('severity.data.select');
        Route::post('/{id}', 'SeverityController@update')->name('severity.update');
    });

    Route::group(['prefix' => 'item', 'namespace' => 'Admin'], function() {
        Route::get('/', 'ItemController@index')->name('item');
        Route::post('/', 'ItemController@create')->name('item.add');
        Route::post('/delete', 'ItemController@delete')->name('item.delete');
        Route::get('/data', 'ItemController@data')->name('item.data');
        Route::get('/data/select', 'ItemController@selectDataFormat')->name('item.data.select');
        Route::post('/{id}', 'ItemController@update')->name('item.update');
    });

    //kind-of-damage-type
    Route::group(['prefix' => 'kind-of-damage-type', 'namespace' => 'Admin'], function() {
        Route::get('/', 'SetKindOfDamageController@index')->name('kind-of-damage-type');
        Route::post('/', 'SetKindOfDamageController@create')->name('kind-of-damage-type.add');
        Route::post('/delete', 'SetKindOfDamageController@delete')->name('kind-of-damage-type.delete');
        Route::post('/{id}', 'SetKindOfDamageController@update')->name('kind-of-damage-type.update');
        Route::get('/data', 'SetKindOfDamageController@data')->name('kind-of-damage-type.data');

    });

    Route::group(['prefix' => 'report', 'namespace' => 'Admin'], function() {
        Route::get('/', 'ReportController@index')->name('report');
        Route::get('/data', 'ReportController@data')->name('report.data');
        Route::post('/update', 'ReportController@update')->name('report.update');
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
            Route::post('/', 'BranchController@store')->name('branch.store');
            Route::get('/data', 'BranchController@data')->name('branch.data');
            Route::post('/delete', 'BranchController@delete')->name('branch.delete');
            Route::post('/{id}', 'BranchController@update')->name('branch.update');
        });


    });

});

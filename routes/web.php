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


Auth::routes();

Route::get('/', 'PublicController@index')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');

Route::post('locations/save', 'LocationsController@save')
    ->name('locations.save')->middleware('auth');

Route::get('locations/delete/{locationId}', 'LocationsController@delete')
    ->name('locations.delete')->middleware('auth');

Route::get('locations', 'LocationsController@index')
    ->name('locations.index')->middleware('auth');

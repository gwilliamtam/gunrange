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

Route::prefix('locations')->group(function () {
    Route::post('save', 'LocationsController@save')
        ->name('locations.save')->middleware('auth');

    Route::get('delete/{locationId}', 'LocationsController@delete')
        ->name('locations.delete')->middleware('auth');

    Route::get('', 'LocationsController@index')
        ->name('locations.index')->middleware('auth');
});

Route::prefix('gear')->group(function () {
    Route::post('save', 'GearController@save')
        ->name('gear.save')->middleware('auth');

    Route::get('delete/{gearId}', 'GearController@delete')
        ->name('gear.delete')->middleware('auth');

    Route::get('', 'GearController@index')
        ->name('gear.index')->middleware('auth');
});

Route::prefix('ammo')->group(function () {
    Route::post('save', 'AmmoController@save')
        ->name('ammo.save')->middleware('auth');

    Route::get('delete/{ammoId}', 'AmmoController@delete')
        ->name('ammo.delete')->middleware('auth');

    Route::get('', 'AmmoController@index')
        ->name('ammo.index')->middleware('auth');
});

Route::prefix('practice')->group(function () {
    Route::get('add/{practiceId}', 'PracticeController@addElements')
        ->name('practice.add')->middleware('auth');

    Route::post('save', 'PracticeController@save')
        ->name('practice.save')->middleware('auth');

    Route::post('addTarget', 'PracticeController@addTarget')
        ->name('practice.addTarget')->middleware('auth');

    Route::get('delete/{practiceId}', 'PracticeController@delete')
        ->name('practice.delete')->middleware('auth');

    Route::get('', 'PracticeController@index')
        ->name('practice.index')->middleware('auth');
});


Route::prefix('target')->group(function () {
    Route::get('remove/{elementType}/{practiceId}', 'PracticeController@removePracticeElement')
        ->middleware('auth');
    Route::get('update/{targetId}', 'PracticeController@updateTarget')
        ->middleware('auth');
});

Route::prefix('dashboard')->group(function () {
    Route::get('', 'DashboardController@index')
        ->name('dashboard.index')->middleware('auth');
});


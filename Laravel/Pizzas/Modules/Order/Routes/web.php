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

Route::prefix('order')->group(function() {
    Route::get('/', 'OrderController@index')->name('index_order');
    Route::get('/update/{id}', 'OrderController@update')->name('complete_order');
    Route::post('/update/{id}', 'OrderController@update')->name('update_order');
    Route::get('/edit/{id}', 'OrderController@edit')->name('edit_order');
    Route::get('/destroy/{id}', 'OrderController@destroy')->name('destroy_order');
    Route::get('/create', 'OrderController@create')->name('create_order');
    Route::post('/store', 'OrderController@store')->name('store_order');
});

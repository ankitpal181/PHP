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

Route::prefix('menu')->group(function() {
    Route::get('/', 'MenuController@index')->name('index_menu');
    Route::get('/edit', 'MenuController@edit')->name('edit_menu');
    Route::post('/update', 'MenuController@update')->name('update_menu');
    Route::get('/create', 'MenuController@create')->name('create_menu');
    Route::post('/store', 'MenuController@store')->name('store_menu');
});

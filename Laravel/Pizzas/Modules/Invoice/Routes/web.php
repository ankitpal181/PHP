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

Route::prefix('invoice')->group(function() {
    Route::get('/', 'InvoiceController@index')->name('index_invoice');
    Route::get('/create/{order_id}', 'InvoiceController@create')->name('create_invoice');
    Route::post('/store/{order_id}', 'InvoiceController@store')->name('store_invoice');
    Route::get('/update/{order_id}', 'InvoiceController@update')->name('update_invoice');
});

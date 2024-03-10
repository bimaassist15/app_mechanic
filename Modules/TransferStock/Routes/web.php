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

Route::prefix('transferstock')->middleware('auth')->group(function() {
    Route::get('/stock', 'TransferStockController@index')->name('stock.index');
    Route::get('/stokmasuk', 'StockMasukController@index')->name('stokmasuk.index');
    Route::get('/stokkeluar', 'StockKeluarController@index')->name('stokkeluar.index');
});

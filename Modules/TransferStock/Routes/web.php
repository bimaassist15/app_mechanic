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

Route::prefix('transferStock')->middleware('auth')->group(function () {
    Route::get('/transaksi', 'TransferStockController@index')->name('transferStock.transaksi.index');
    Route::get('/transaksi/checkBarang', 'TransferStockController@checkBarang')->name('transferStock.transaksi.checkBarang');
    Route::post('/transaksi/transferBarang', 'TransferStockController@transferBarang')->name('transferStock.transaksi.transferBarang');

    Route::get('/masuk', 'StockMasukController@index')->name('masuk.index');
    Route::get('/masuk/{id}', 'StockMasukController@show')->name('masuk.show');
    Route::get('/masuk/{id}/print', 'StockMasukController@print')->name('masuk.print');
    Route::delete('/masuk/{id}/destroy', 'StockMasukController@destroy')->name('masuk.destroy');
    Route::get('/masuk/checkStatus/validation', 'StockMasukController@checkStatus')->name('transferStock.masuk.checkStatus');
    Route::put('/masuk/{id}/updateStatus', 'StockMasukController@updateStatus')->name('masuk.updateStatus');


    Route::get('/keluar', 'StockKeluarController@index')->name('keluar.index');
    Route::get('/keluar/{id}', 'StockKeluarController@show')->name('keluar.show');
    Route::get('/keluar/{id}/print', 'StockKeluarController@print')->name('keluar.print');
    Route::delete('/keluar/{id}/destroy', 'StockKeluarController@destroy')->name('keluar.destroy');
    Route::get('/keluar/checkStatus/validation', 'StockKeluarController@checkStatus')->name('transferStock.keluar.checkStatus');
});

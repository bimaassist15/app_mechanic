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

Route::prefix('transaction')->group(function() {
    Route::get('/', 'TransactionController@index');
    Route::resource('kasir', 'KasirController');
    Route::resource('pembelian', 'PembelianController');
    Route::get('pembelian/print/transaction', 'PembelianController@print')->name('pembelian.print');
    Route::get('belumLunas', 'BelumLunasController@index')->name('belumLunas.index');
    Route::get('lunas', 'LunasController@index')->name('lunas.index');
});

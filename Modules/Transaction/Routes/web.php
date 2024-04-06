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

Route::prefix('transaction')->middleware('auth')->group(function () {
    Route::get('/', 'TransactionController@index');
    Route::resource('kasir', 'KasirController');
    Route::resource('pembelian', 'PembelianController');
    Route::get('pembelian/print/transaction', 'PembelianController@print')->name('pembelian.print');
    Route::get('belumLunas', 'BelumLunasController@index')->name('belumLunas.index');
    Route::get('belumLunas/{id}/show', 'BelumLunasController@show')->name('belumLunas.show');
    Route::get('belumLunas/{id}/jatuhTempo', 'BelumLunasController@jatuhTempo')->name('belumLunas.jatuhTempo');
    Route::put('belumLunas/{id}/jatuhTempo', 'BelumLunasController@updateJatuhTempo')->name('belumLunas.updateJatuhTempo');
    Route::put('belumLunas/{id}/remember', 'BelumLunasController@updateRemember')->name('belumLunas.updateRemember');

    Route::get('lunas', 'LunasController@index')->name('lunas.index');
    Route::get('lunas/{id}/show', 'LunasController@show')->name('lunas.show');
    
    Route::resource('pembelianCicilan', 'PembelianCicilanController');
    Route::get('pembelianCicilan/print/transaction', 'PembelianCicilanController@print')->name('pembelianCicilan.print');
});

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

Route::prefix('purchase')->middleware('auth')->group(function () {
    Route::get('/', 'PurchaseController@index');
    Route::resource('kasir', 'KasirController');
    Route::resource('penjualan', 'PenjualanController');
    Route::get('penjualan/print/purchase', 'PenjualanController@print')->name('penjualan.print');
    Route::get('belumLunas', 'BelumLunasController@index')->name('belumLunas.index');
    Route::get('belumLunas/{id}/show', 'BelumLunasController@show')->name('belumLunas.show');
    Route::get('belumLunas/{id}/jatuhTempo', 'BelumLunasController@jatuhTempo')->name('belumLunas.jatuhTempo');
    Route::put('belumLunas/{id}/jatuhTempo', 'BelumLunasController@updateJatuhTempo')->name('belumLunas.updateJatuhTempo');
    Route::put('belumLunas/{id}/remember', 'BelumLunasController@updateRemember')->name('belumLunas.updateRemember');

    Route::get('lunas', 'LunasController@index')->name('lunas.index');
    Route::get('lunas/{id}/show', 'LunasController@show')->name('lunas.show');
    Route::resource('penjualanCicilan', 'PenjualanCicilanController');
    Route::get('penjualanCicilan/print/purchase', 'PenjualanCicilanController@print')->name('penjualanCicilan.print');
});

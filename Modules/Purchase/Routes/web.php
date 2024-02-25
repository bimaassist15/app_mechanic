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

Route::prefix('purchase')->group(function() {
    Route::get('/', 'PurchaseController@index');
    Route::resource('kasir', 'KasirController');
    Route::resource('penjualan', 'PenjualanController');
    Route::get('penjualan/print/purchase', 'PenjualanController@print')->name('penjualan.print');
    Route::get('belumLunas', 'BelumLunasController@index')->name('belumLunas.index');
    Route::get('lunas', 'LunasController@index')->name('lunas.index');
});

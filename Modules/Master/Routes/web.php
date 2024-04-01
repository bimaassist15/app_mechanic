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

Route::prefix('master')->middleware('auth')->group(function () {
    Route::get('/', 'MasterController@index');
    Route::resource('kategori', 'KategoriController');
    Route::resource('satuan', 'SatuanController');
    Route::resource('barang', 'BarangController');
    Route::resource('serialBarang', 'SerialBarangController');
    Route::get('generateBarcode', 'GenerateBarcodeController@index')->name('master.generateBarcode.index');
    Route::get('generateBarcode/print', 'GenerateBarcodeController@print')->name('master.generateBarcode.print');
    Route::resource('customer', 'CustomerController');
    Route::resource('kendaraan', 'KendaraanController');
    Route::resource('supplier', 'SupplierController');
    Route::resource('kategoriServis', 'KategoriServisController');
    Route::resource('hargaServis', 'HargaServisController');
    Route::resource('kategoriPembayaran', 'KategoriPembayaranController');
    Route::resource('subPembayaran', 'SubPembayaranController');
    Route::resource('kategoriPendapatan', 'KategoriPendapatanController');
    Route::resource('kategoriPengeluaran', 'KategoriPengeluaranController');
});

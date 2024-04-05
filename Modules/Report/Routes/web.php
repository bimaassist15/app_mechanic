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

Route::prefix('report')->middleware('auth')->group(function () {
    Route::get('/', 'ReportController@index');

    Route::resource('pendapatan', 'PendapatanController');
    Route::resource('pengeluaran', 'PengeluaranController');
    Route::get('labaBersih', 'LabaBersihController@index')->name('labaBersih.index');
    Route::get('labaBersih/print', 'LabaBersihController@print')->name('labaBersih.print');

    Route::get('kasir', 'KasirController@index')->name('kasir.index');
    Route::get('customer', 'CustomerController@index')->name('customer.index');
    Route::get('periode', 'PeriodeController@index')->name('periode.index');
    Route::get('produk', 'ProdukController@index')->name('produk.index');
    Route::get('supplier', 'SupplierController@index')->name('supplier.index');
    Route::get('pembelianProduk', 'PembelianProdukController@index')->name('pembelianProduk.index');
    Route::get('periodePembelian', 'PeriodePembelianController@index')->name('periodePembelian.index');
    Route::get('barangTerlaris', 'BarangTerlarisController@index')->name('barangTerlaris.index');
    Route::get('stokTerkecil', 'StokTerkecilController@index')->name('stokTerkecil.index');
    Route::get('profitPribadi', 'ProfitPribadiController@index')->name('profitPribadi.index');
    Route::get('mekanik', 'MekanikController@index')->name('mekanik.index');
    Route::get('servisPeriode', 'ServisPeriodeController@index')->name('servisPeriode.index');
    Route::get('statusServis', 'StatusServisController@index')->name('statusServis.index');
    Route::get('statusServisPeriode', 'StatusServisPeriodeController@index')->name('statusServisPeriode.index');
});

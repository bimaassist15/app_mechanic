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

Route::prefix('service')->middleware('auth')->group(function () {
    Route::get('/', 'ServiceController@index');
    Route::resource('penerimaanServis', 'PenerimaanServisController');
    Route::get('penerimaanServis/print/{id}/penerimaanServis', 'PenerimaanServisController@print')->name('penerimaanServis.print');
    Route::get('penerimaanServis/detail/{id}/penerimaanServis', 'PenerimaanServisController@detail')->name('penerimaanServis.detail');

    Route::get('pengembalianServis', 'PengembalianServisController@index')->name('pengembalianServis.index');
    Route::resource('kendaraanServis', 'KendaraanServisController');
    Route::get('kendaraanServis/detailKendaraanServis/service', 'KendaraanServisController@detailKendaraanServis')->name('kendaraanServis.detailKendaraanServis.service');
    Route::get('kendaraanServis/print/service', 'KendaraanServisController@print')->name('kendaraanServis.print.service');

    Route::resource('orderServis', 'OrderServisController');
});

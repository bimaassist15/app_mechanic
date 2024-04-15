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

    // penerimaan servis
    Route::resource('penerimaanServis', 'PenerimaanServisController');
    Route::get('penerimaanServis/print/{id}/penerimaanServis', 'PenerimaanServisController@print')->name('penerimaanServis.print');
    Route::get('penerimaanServis/detail/{id}/penerimaanServis', 'PenerimaanServisController@detail')->name('penerimaanServis.detail');


    // penerimaan servis
    Route::resource('estimasiServis', 'EstimasiServisController');
    Route::put('estimasiServis/remember/{id}/estimasi', 'EstimasiServisController@remember')->name('estimasiServis.remember');
    Route::post('estimasiServis/{id}/nextProcess', 'EstimasiServisController@nextProcess')->name('estimasiServis.nextProcess');

    // pengembalian servis
    Route::get('pengembalianServis', 'PengembalianServisController@index')->name('pengembalianServis.index');
    Route::get('pengembalianServis/{id}', 'PengembalianServisController@show')->name('pengembalianServis.show');
    Route::put('pengembalianServis/{id}/update', 'PengembalianServisController@update')->name('pengembalianServis.update');

    // kendaraan servis
    Route::resource('kendaraanServis', 'KendaraanServisController');
    Route::get('kendaraanServis/detailKendaraanServis/service', 'KendaraanServisController@detailKendaraanServis')->name('kendaraanServis.detailKendaraanServis.service');
    Route::get('kendaraanServis/print/service', 'KendaraanServisController@print')->name('kendaraanServis.print.service');

    // order servis
    Route::resource('orderServis', 'OrderServisController');

    // order barang
    Route::resource('orderBarang', 'OrderBarangController');

    // print kendaaraan servis
    Route::get('print/kendaraan/servis', 'PrintServisController@index')->name('service.print.kendaraan');
    Route::get('print/kendaraan/selesaiServis', 'PrintServisController@selesaiServis')->name('service.print.selesaiServis');

    // check file
    Route::post('checkFile', 'ServiceController@checkFile')->name('service.checkFile');

    // service garansi
    Route::get('garansi', 'GaransiController@index')->name('garansi.index');
    Route::get('garansi/{id}', 'GaransiController@show')->name('garansi.show');
    Route::put('garansi/{id}/update', 'GaransiController@update')->name('garansi.update');

    // service berkala
    Route::get('berkala', 'BerkalaController@index')->name('berkala.index');
    Route::get('berkala/{id}', 'BerkalaController@show')->name('berkala.show');
    Route::put('berkala/{id}/update', 'BerkalaController@update')->name('berkala.update');
    Route::put('berkala/setReminded/{id}/update', 'BerkalaController@setReminded')->name('berkala.setReminded');

    // service mekanik
    Route::get('mekanik', 'MekanikController@index')->name('mekanik.index');
    Route::get('mekanik/{id}', 'MekanikController@show')->name('mekanik.show');

    // service mekanik garansi
    Route::get('mekanikGaransi', 'MekanikGaransiController@index')->name('mekanikGaransi.index');
    Route::get('mekanikGaransi/{id}', 'MekanikGaransiController@show')->name('mekanikGaransi.show');

    // load data
    Route::get('outputUpdateService/{id}', 'PenerimaanServisController@outputUpdateService')->name('service.outputUpdateService');
});

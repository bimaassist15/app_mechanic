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
});

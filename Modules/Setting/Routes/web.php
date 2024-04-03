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

Route::prefix('setting')->middleware('auth')->group(function() {
    Route::get('/', 'SettingController@index');
    Route::get('/logout', 'SettingController@logout');
    Route::resource('cabang', 'CabangController');
    Route::resource('roles', 'RolesController');
    Route::resource('user', 'UserController');
    Route::resource('backup', 'BackupController');
    Route::resource('restore', 'RestoreController');
});

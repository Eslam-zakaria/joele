<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Setting\\Controllers\\';

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::put('settings/update', 'SettingController@update')->name('settings.update');
    Route::post('settings/sitemap', 'SettingController@site_map')->name('settings.sitemap');
});


Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/settings', 'SettingController@index')->name('api.settings.index');
});


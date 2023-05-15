<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Permission\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/permissions', 'PermissionsController@index')->name('api.permissions.index');
    Route::post('/permission/{permission}/status', 'PermissionsController@changeStatus')->name('api.permission.status');
    Route::delete('/permission/{permission}', 'PermissionsController@destroy')->name('api.permission.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::get('admins/permission/{user}','PermissionsController@index')->name('permissions.index');
    Route::put('admins/permission/{user}','PermissionsController@update')->name('permissions.update');
});

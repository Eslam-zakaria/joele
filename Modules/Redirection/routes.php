<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Redirection\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/redirection', 'RedirectionsController@index')->name('api.redirections.index');
    Route::post('/redirection/{redirection}/status', 'RedirectionsController@changeStatus')->name('api.redirection.status');
    Route::delete('/redirection/{redirection}', 'RedirectionsController@destroy')->name('api.redirection.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('redirections', 'RedirectionsController')->except('show');
});

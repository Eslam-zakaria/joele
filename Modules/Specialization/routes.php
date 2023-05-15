<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Specialization\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/specializations', 'SpecializationsController@index')->name('api.specializations.index');
    Route::post('/specialization/{specialization}/status', 'SpecializationsController@changeStatus')->name('api.specialization.status');
    Route::delete('/specialization/{specialization}', 'SpecializationsController@destroy')->name('api.specialization.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('specializations', 'SpecializationsController')->except('show', 'destroy');
});

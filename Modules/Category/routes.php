<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Category\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/categories', 'CategoriesController@index')->name('api.categories.index');
    Route::post('/category/{category}/status', 'CategoriesController@changeStatus')->name('api.category.status');
    Route::delete('/category/{category}', 'CategoriesController@destroy')->name('api.category.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('categories', 'CategoriesController')->except('show', 'destroy');
});

<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Slider\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/sliders', 'SliderController@index')->name('api.sliders.index');
    Route::post('/slider/{slider}/status', 'SliderController@changeStatus')->name('api.slider.status');
    Route::delete('/slider/{slider}', 'SliderController@destroy')->name('api.slider.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('sliders', 'SliderController')->except('show', 'destroy');
    Route::get('slider-copy/{slider}', 'SliderController@replicate')->name('slider-copy');

});

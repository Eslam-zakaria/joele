<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Testimonial\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/testimonials', 'TestimonialsController@index')->name('api.testimonials.index');
    Route::post('/testimonial/{testimonial}/status', 'TestimonialsController@changeStatus')->name('api.testimonial.status');
    Route::delete('/testimonial/{testimonial}', 'TestimonialsController@destroy')->name('api.testimonial.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('testimonials', 'TestimonialsController')->except('show', 'destroy');
});

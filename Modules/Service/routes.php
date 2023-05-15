<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Service\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/services', 'ServiceController@index')->name('api.services.index');
    Route::post('/service/{service}/status', 'ServiceController@changeStatus')->name('api.service.status');
    Route::delete('/service/{service}', 'ServiceController@destroy')->name('api.service.destroy');
});

Route::prefix('/api')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/services', 'ServiceController@index')->name('api.services.index');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('services', 'ServiceController')->except('show', 'destroy');
    Route::get('service-copy/{service}', 'ServiceController@replicate')->name('service-copy');
    Route::get('/service-Details/{question}/delete', 'ServiceController@deleteQuestion')->name('service.details.deleted');
});

Route::prefix('{lang}/api')->middleware('language')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/specificitiesByServices/{service}', 'ServiceController@listSpecificitiesByServices')->name('api.services.specificities');
});


if (Request::segment(1) == 'en') {
    App::setLocale(Request::segment(1));
    Config::set('translatable.locale', Request::segment(1));
    Config::set('app.locale', Request::segment(1));
}
else {
    App::setLocale('ar');
    Config::set('translatable.locale', '');
    Config::set('app.locale', '');
}

Route::group(['prefix' => Config::get('app.locale'),'namespace' => $namespace.'Web'], function()
{
    Route::get('/services', 'ServiceController@index')->name('web.services.index');
    Route::get('services/{slug?}', 'ServiceController@getServices')->name('web.services.list');
    Route::get('/services-details/{slug?}', 'ServiceController@details')->name('web.services.details');
});

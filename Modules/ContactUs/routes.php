<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\ContactUs\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('contact-us', 'ContactUsController@index')->name('api.contact-us.index');
    Route::delete('/contact-us/{contact_u}', 'ContactUsController@destroy')->name('api.contact-us.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('contact-us', 'ContactUsController')->only('index', 'show', 'update');
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
    Route::resource('contact-us', 'ContactUsController')->only('index', 'store');
});

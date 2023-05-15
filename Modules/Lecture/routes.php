<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Lecture\\Controllers\\';

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('lectures', 'LecturesController')->except('show', 'destroy');
    Route::get('lecture-copy/{lecture}', 'LecturesController@replicate')->name('lecture-copy');
});

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/lectures', 'LecturesController@index')->name('api.lectures.index');
    Route::post('/lecture/{lecture}/status', 'LecturesController@changeStatus')->name('api.lecture.status');
    Route::delete('/lecture/{lecture}', 'LecturesController@destroy')->name('api.lecture.destroy');
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
    Route::get('/lectures', 'LecturesController@index')->name('web.lectures.index');
});

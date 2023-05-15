<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Cases\\Controllers\\';

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('cases', 'CasesController')->except('show', 'destroy');
    Route::get('case-copy/{case}', 'CasesController@replicate')->name('case-copy');
});

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/cases', 'CasesController@index')->name('api.cases.index');
    Route::post('/case/{case}/status', 'CasesController@changeStatus')->name('api.case.status');
    Route::delete('/case/{case}', 'CasesController@destroy')->name('api.case.destroy');
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
    Route::get('/cases', 'CasesController@index')->name('web.cases.index');
});

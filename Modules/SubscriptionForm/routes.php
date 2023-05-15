<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\SubscriptionForm\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('subscription-form', 'SubscriptionFormController@index')->name('api.subscription-form.index');
    Route::delete('/subscription-form/{subscription_form}', 'SubscriptionFormController@destroy')->name('api.subscription-form.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('subscription-form', 'SubscriptionFormController')->only('index');
    Route::get('/export-subscription-form', 'SubscriptionFormController@exportCsv')->name('subscription-form.export');
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

Route::group(['prefix' => Config::get('app.locale'),'namespace' => $namespace.'Web'], function(){
    Route::post('subscription-form', 'SubscriptionFormController@store')->name('web.subscription-form.index');
});

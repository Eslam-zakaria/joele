<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Booking\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/bookings', 'BookingController@index')->name('api.bookings.index');
    Route::post('/booking/{booking}/status', 'BookingController@changeStatus')->name('api.booking.status');
    Route::delete('/booking/{booking}', 'BookingController@destroy')->name('api.booking.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('bookings', 'BookingController')->only('index', 'edit', 'update');
    Route::get('/export-bookings', 'BookingController@exportCsv')->name('bookings.export');
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
    Route::get('/book-an-appointment', 'BookingController@index')->name('web.booking.index');
    Route::post('/book-store', 'BookingController@store')->name('web.booking.store');
    Route::get('/validate-available-booking', 'BookingController@validateAvailableBooking')->name('web.booking.check.availability');

});

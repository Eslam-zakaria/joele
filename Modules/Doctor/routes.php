<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Doctor\\Controllers\\';

Route::prefix('/api')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/doctors/get', 'DoctorController@get')->name('api.doctors.get');
    Route::get('/doctors/list', 'DoctorController@list')->name('api.doctors.list');
    Route::get('/doctors/list-data', 'DoctorController@listData')->name('api.doctors.list-data');
    Route::post('/doctor/{doctor}/status', 'DoctorController@changeStatus')->name('api.doctor.status');
    Route::delete('/doctor/{doctor}', 'DoctorController@destroy')->name('api.doctor.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('doctors', 'DoctorController')->except('show', 'destroy');
    Route::get('doctor/working-days/{doctor}', 'DoctorWorkingDaysController@index')->name('doctor.working-days.index');
    Route::post('doctor/working-days/{doctor}/store', 'DoctorWorkingDaysController@store')->name('doctor.working-days.store');
    Route::get('doctor-copy/{doctor}', 'DoctorController@replicate')->name('doctor-copy');
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
    Route::get('/doctors', 'DoctorController@index')->name('web.doctors.index');
    Route::get('/doctor/{slug}', 'DoctorController@details')->name('web.doctors.details');
});

Route::prefix(Config::get('app.locale').'/api')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/doctors/appointments/{doctor}/{branch}', 'DoctorController@findDoctorAppointments')->name('api.doctors.appointments');
});

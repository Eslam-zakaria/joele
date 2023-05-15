<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\InsuranceCompany\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/insurance-companies', 'InsuranceCompaniesController@index')->name('api.insurance-companies.index');
    Route::delete('/insurance-company/{insurance_company}', 'InsuranceCompaniesController@destroy')->name('api.insurance-companies.destroy');
    Route::post('/insurance-companies/{insurance_company}/status', 'InsuranceCompaniesController@changeStatus')->name('api.insurance-companies.status');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('insurance-companies', 'InsuranceCompaniesController')->except('show', 'destroy');
    Route::get('insurance-company-copy/{insurance_company}', 'InsuranceCompaniesController@replicate')->name('insurance-company-copy');
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

Route::group(['prefix' => Config::get('app.locale'), 'namespace' => $namespace.'Web'], function () {
    Route::get('insurance-companies', 'InsuranceCompaniesController@index')->name('web.insurance-companies.index');
});

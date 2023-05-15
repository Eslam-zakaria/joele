<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Branch\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/branches/list', 'BranchesController@list')->name('api.branches.list');
    Route::get('/branches/get', 'BranchesController@get')->name('api.branches.get');
    Route::post('/branch/{branch}/status', 'BranchesController@changeStatus')->name('api.branch.status');
    Route::delete('/branch/{branch}', 'BranchesController@destroy')->name('api.branch.destroy');
});

Route::prefix('{lang}/api')->middleware('language')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/branches/specificities/{branche}', 'BranchesController@listSpecialtiesbyBrnache')->name('api.branches.specificities');
    Route::get('/branchesByservices/{service}', 'BranchesController@listBrnacheByServices')->name('api.branches.services');
});
Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('branches', 'BranchesController')->except('show', 'delete');
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
    Route::get('/branches', 'BranchesController@index')->name('web.branches.index');
});

Route::prefix(Config::get('app.locale').'/api')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/branche/doctors/{branch}', 'BranchesController@listDoctorsByBranch')->name('api.branch.doctors');
});

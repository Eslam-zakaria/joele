<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Review\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/reviews', 'ReviewsController@index')->name('api.reviews.index');
    Route::post('/review/{review}/status', 'ReviewsController@changeStatus')->name('api.review.status');
    Route::delete('/review/{review}', 'ReviewsController@destroy')->name('api.review.destroy');
    Route::get('reviews-questions', 'ReviewQuestionsController@index')->name('api.reviews-questions.index');
    Route::post('/question/{review_question}/status', 'ReviewQuestionsController@changeStatus')->name('api.reviews-questions.status');
    Route::delete('/question/{review_question}', 'ReviewQuestionsController@destroy')->name('api.reviews-questions.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('reviews', 'ReviewsController')->only('index', 'edit', 'update');
    Route::resource('reviews-questions', 'ReviewQuestionsController')->except('show', 'destroy');
    Route::get('/export-reviews', 'ReviewsController@exportCsv')->name('reviews.export');
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

Route::group(['prefix' => Config::get('app.locale'),'namespace' => $namespace.'Web'], function() {
    Route::get('review', 'ReviewsController@create')->name('web.reviews.create');
    Route::post('review/store', 'ReviewsController@store')->name('web.reviews.store');
});

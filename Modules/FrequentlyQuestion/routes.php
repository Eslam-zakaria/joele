<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\FrequentlyQuestion\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    # Route for questions categories.
    Route::get('/questions-category', 'QuestionsCategoryController@index')->name('api.questions-category.index');
    Route::delete('/questions-category/{question_category}', 'QuestionsCategoryController@destroy')->name('api.questions-category.destroy');
    Route::post('/questions-category/{question_category}/status', 'QuestionsCategoryController@changeStatus')->name('api.questions-category.status');

    # Route for frequently questions.
    Route::get('/frequently-questions', 'FrequentlyQuestionsController@index')->name('api.frequently-questions.index');
    Route::delete('/frequently-question/{frequently_question}', 'FrequentlyQuestionsController@destroy')->name('api.frequently-question.destroy');
    Route::post('/frequently-question/{frequently_question}/status', 'FrequentlyQuestionsController@changeStatus')->name('api.frequently-question.status');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('questions-category', 'QuestionsCategoryController')->except('show', 'destroy');
    Route::resource('frequently-questions', 'FrequentlyQuestionsController')->except('show', 'destroy');
    Route::get('frequently-question-copy/{frequently_question}', 'FrequentlyQuestionsController@replicate')->name('frequently-question-copy');
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
    Route::get('frequently-questions', 'FrequentlyQuestionsController@index')->name('web.frequently-questions.index');
});

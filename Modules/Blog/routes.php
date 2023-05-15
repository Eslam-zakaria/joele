<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Blog\\Controllers\\';

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('blogs', 'BlogsController')->except('show', 'destroy');
    Route::get('blog-copy/{blog}', 'BlogsController@reCopy')->name('blog-copy');
    Route::get('blog-faq/{question}/delete', 'BlogsController@Faqdelete')->name('blog-faq.delete');
    Route::get('/ajax-BlogsByLocale', 'BlogsController@BlogsAjax');
});

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/blogs', 'BlogsController@index')->name('api.blogs.index');
    Route::post('/blog/{blog}/status', 'BlogsController@changeStatus')->name('api.blog.status');
    Route::delete('/blog/{blog}', 'BlogsController@destroy')->name('api.blog.destroy');
});

Route::prefix('/api')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/blogs', 'BlogsController@index')->name('api.blogs.index');
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
    Route::get('/blogs', 'BlogsController@index')->name('web.blogs.index');
    Route::get('/blog/{slug}', 'BlogsController@details')->name('web.blog.show');
    Route::post('/blog/comment/{blog}', 'BlogsController@comment')->name('web.blog.comment');
});

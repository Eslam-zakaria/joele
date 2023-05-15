<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Comment\\Controllers\\';

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('comments', 'CommentController')->only('index', 'edit', 'update', 'create', 'store');
    Route::get('/comments/{comment}/approve', 'CommentController@approve')->name('comments.approve');
    Route::get('/comments/{comment}/disapprove', 'CommentController@disapprove')->name('comments.disapprove');
});

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/comments', 'CommentController@index')->name('api.comments.index');
    Route::post('/comment/{comment}/status', 'CommentController@changeStatus')->name('api.comment.status');
    Route::delete('/comment/{comment}', 'CommentController@destroy')->name('api.comment.destroy');
});



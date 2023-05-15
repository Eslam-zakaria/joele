<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/pending/users', function () { return view('admin.dashboard.index'); })->name('admin.pending.users');
    Route::get('/pending/tickets', function () { return view('admin.dashboard.index'); })->name('admin.pending.tickets');
    Route::get('/transactions', function () { return view('admin.dashboard.index'); })->name('admin.transactions.index');
    Route::get('/notifications', function () { return view('admin.dashboard.index'); })->name('admin.notifications.index');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', 'Admin')->as('admin.')->group( function () {
    Route::get('/', function () { return view('admin.dashboard.index'); })->name('dashboard.index');
    Route::resource('users', 'UserController')->except('show', 'destroy');
});

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', 'Api')->group( function () {
    Route::get('/users', 'UserController@index')->name('api.users.index');
    Route::post('/user/{user}/status', 'UserController@changeStatus')->name('api.user.status');
    Route::delete('/user/{user}', 'UserController@destroy')->name('api.user.destroy');
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout')->name('logout')->middleware('auth:web');

Route::get('login', 'Auth\LoginController@showLoginform')->name('login');

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

Route::group(['prefix' => Config::get('app.locale')], function() {
    Route::get('/', 'HomeController@index')->name('web.home.index');
    Route::post('page/subscribe', 'HomeController@subscribe')->name('web.home.subscribe');
    Route::get('about-us', 'PagesController@contactUs')->name('web.about-us');
    Route::get('terms-condition', 'PagesController@termsCondition')->name('web.terms-condition');
    Route::get('/search/results', 'HomeController@search')->name('web.home.search');
});

Route::get('/robots.txt', 'HomeController@robots')->name('web.home.robots');



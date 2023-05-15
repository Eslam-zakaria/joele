<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Modules\\Offer\\Controllers\\';

Route::prefix('/api')->middleware('auth:web')->attribute('namespace', $namespace.'Api')->group( function () {
    Route::get('/offers', 'OfferController@index')->name('api.offers.index');

    Route::post('/offer/{offer}/status', 'OfferController@changeStatus')->name('api.offer.status');
    Route::delete('/offer/{offer}', 'OfferController@destroy')->name('api.offer.destroy');
});

Route::prefix('/super')->middleware('auth:web')->attribute('namespace', $namespace.'Admin')->as('admin.')->group( function () {
    Route::resource('offers', 'OfferController')->except('show', 'destroy');
    Route::get('offer-copy/{offer}', 'OfferController@replicate')->name('offer-copy');
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
    Route::any('/offers/thanks', 'OfferController@thanks')->name('web.bookings.thanks');
    Route::any('/latest-offers', 'OfferController@index')->name('web.offers.index');
    Route::get('/offers/{slug?}', 'OfferController@lists')->name('web.offers.lists');
    Route::get('/offer/{slug}/{offerId}/book', 'OfferController@bookoffer')->name('web.offers.book');
    Route::post('/offer-book-checkTabby', 'OfferController@checkTabby')->name('web.offer-booking.checkTabby');
    Route::post('/offer-book-store', 'OfferController@store')->name('web.offer-booking.store');
    Route::get('page/payment/{referal_code?}/{installment?}', 'OfferController@payment')->name('web.bookings.payment');
    Route::any('page/offer-installment', 'OfferController@failedInstallment')->name('web.bookings.failedInstallment');
    Route::any('page/tabby/offer-installment', 'OfferController@failedTabbyInstallment')->name('web.bookings.failedTabbyInstallment');
    Route::any('page/offer/installment-thanks', 'OfferController@thanksInstallment')->name('web.bookings.installment.thanks');
});

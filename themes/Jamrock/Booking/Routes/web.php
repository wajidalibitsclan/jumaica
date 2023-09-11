<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('booking.booking_route_prefix')],function(){
    Route::get('/{code}/extra','ExtraController@index')->name('booking.extra');
    Route::post('/{code}/extra/store','ExtraController@store')->name('booking.extra.store');
    Route::get('/{code}/extra/remove','ExtraController@remove');

});

Route::get('/remove-user-stripe_customer_id-xxxx','ExtraController@test');
Route::post('/get-combination','ExtraController@getCombination');
Route::post('/save_extra','ExtraController@saveExtra');

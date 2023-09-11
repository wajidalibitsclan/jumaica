<?php
use \Illuminate\Support\Facades\Route;
Route::group(['prefix'=>env('EVENT_ROUTE_PREFIX','event')],function(){
    Route::get('/','EventController@index')->name('event.search'); // Search
    Route::get('/{slug}','EventController@detail')->name('event.detail');// Detail
});

<?php
use \Illuminate\Support\Facades\Route;
Route::group(['prefix'=>config('car.car_route_prefix')],function(){
    Route::get('/{slug}','CarController@detail')->name('car.detail');// Detail
});

<?php
use \Illuminate\Support\Facades\Route;
Route::post('/store/{id}','CarController@store')->name('car.admin.store');

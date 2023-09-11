<?php
use Illuminate\Support\Facades\Route;
Route::get('/create','TourController@create')->name('tour.admin.create');
Route::get('/edit/{id}','TourController@edit')->name('tour.admin.edit');
Route::post('/store/{id}','TourController@store')->name('tour.admin.store');

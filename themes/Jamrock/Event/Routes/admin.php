<?php
use \Illuminate\Support\Facades\Route;
Route::get('/create','EventController@create')->name('event.admin.create');
Route::get('/edit/{id}','EventController@edit')->name('event.admin.edit');
Route::post('/store/{id}','EventController@store')->name('event.admin.store');


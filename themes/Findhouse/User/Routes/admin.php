<?php
use \Illuminate\Support\Facades\Route;

Route::get('/getForSelect2','UserController@getForSelect2')->name('user.admin.getForSelect2');
Route::get('/','UserController@index')->name('user.admin.index');
Route::get('/create','UserController@create')->name('user.admin.create');
Route::get('/edit/{id}','UserController@edit')->name('user.admin.detail');
Route::post('/store/{id}','UserController@store')->name('user.admin.store');
Route::post('/bulkEdit','UserController@bulkEdit')->name('user.admin.bulkEdit');
Route::get('/password/{id}','UserController@password')->name('user.admin.password');
Route::post('/changepass/{id}','UserController@changepass')->name('user.admin.changepass');




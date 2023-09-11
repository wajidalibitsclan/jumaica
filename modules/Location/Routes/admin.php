<?php
use Illuminate\Support\Facades\Route;

Route::get('/','LocationController@index')->name('location.admin.index');

Route::match(['get'],'/create','LocationController@create')->name('location.admin.create');
Route::match(['get'],'/edit/{id}','LocationController@edit')->name('location.admin.edit');

Route::post('/store/{id}','LocationController@store')->name('location.admin.store');

Route::get('/getForSelect2','LocationController@getForSelect2')->name('location.admin.getForSelect2');
Route::post('/bulkEdit','LocationController@bulkEdit')->name('location.admin.bulkEdit');


Route::group(['prefix' => 'category'],function (){
    Route::get('/','CategoryController@index')->name('location.admin.category.index');
    Route::get('/edit/{id}','CategoryController@edit')->name('location.admin.category.edit');
    Route::post('/store/{id}','CategoryController@store')->name('location.admin.category.store');
    Route::post('/bulkEdit','CategoryController@bulkEdit')->name('location.admin.category.bulkEdit');
});
Route::group(['prefix' => 'popular'],function (){
    Route::get('/','PopularController@index')->name('location.admin.popular.index');
    Route::get('/edit/{id}','PopularController@edit')->name('location.admin.popular.edit');
    Route::post('/store/{id}','PopularController@store')->name('location.admin.popular.store');
    Route::post('/bulkEdit','PopularController@bulkEdit')->name('location.admin.popular.bulkEdit');
});

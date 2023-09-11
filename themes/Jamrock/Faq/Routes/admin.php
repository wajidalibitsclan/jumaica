<?php
use Illuminate\Support\Facades\Route;

Route::get('/','FaqController@index')->name('faq.admin.index');
Route::get('/create','FaqController@create')->name('faq.admin.create');
Route::post('/store/{id}','FaqController@store')->name('faq.admin.store');
Route::get('/edit/{id}','FaqController@edit')->name('faq.admin.edit');
Route::post('/editBulk','FaqController@editBulk')->name('faq.admin.bulkedit');


Route::get('/category','CategoryController@index')->name('faq.admin.category.index');
Route::get('/category/edit/{id}','CategoryController@edit')->name('faq.admin.category.edit');
Route::post('/category/store/{id}','CategoryController@store')->name('faq.admin.category.store');
Route::get('/category/getForSelect2','CategoryController@getForSelect2')->name('faq.admin.category.category.getForSelect2');
Route::post('/category/bulkEdit','CategoryController@bulkEdit')->name('faq.admin.category.bulkEdit');

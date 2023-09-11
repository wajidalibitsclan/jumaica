<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'extra'],function(){
    Route::get('/','ExtraController@index')->name('extra.admin.index');
    Route::get('/create','ExtraController@create')->name('extra.admin.create');
    Route::post('/store/{id}','ExtraController@store')->name('extra.admin.store');
    Route::get('/edit/{id}','ExtraController@edit')->name('extra.admin.edit');
    Route::post('/editBulk','ExtraController@editBulk')->name('extra.admin.bulkedit');

    /*Extra Dropdown*/
    Route::get('/dropdown','DropdownController@index')->name('dropdown.admin.index');
    Route::get('/dropdown/create','DropdownController@create')->name('dropdown.admin.create');
    Route::post('/dropdown/store/{id}','DropdownController@store')->name('dropdown.admin.store');
    Route::get('/dropdown/edit/{id}','DropdownController@edit')->name('dropdown.admin.edit');
    Route::post('/dropdown/editBulk','DropdownController@editBulk')->name('dropdown.admin.bulkedit');

    /*Extra Dropdown*/
    Route::get('/options/{id}','OptionsController@index')->name('options.admin.index');
    Route::get('/options/create/{id}','OptionsController@create')->name('options.admin.create');
    Route::post('/options/store/{id}','OptionsController@store')->name('options.admin.store');
    Route::get('/options/edit/{id}','OptionsController@edit')->name('options.admin.edit');
    Route::post('/options/editBulk','OptionsController@editBulk')->name('options.admin.bulkedit');



    /*Extra combination*/
    Route::get('/combination','CombinationController@index')->name('combination.admin.index');
    Route::get('/combination/create','CombinationController@create')->name('combination.admin.create');
    Route::post('/combination/dropdown','CombinationController@getOptions')->name('combination.admin.options');
    Route::post('/combination/store/{id}','CombinationController@store')->name('combination.admin.store');
    Route::get('/combination/edit/{id}','CombinationController@edit')->name('combination.admin.edit');
    Route::post('/combination/editBulk','CombinationController@editBulk')->name('combination.admin.bulkedit');

});

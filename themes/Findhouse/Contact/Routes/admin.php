<?php
use Illuminate\Support\Facades\Route;

Route::get('/','ContactController@index')->name('contact.admin.index');

<?php
use Illuminate\Support\Facades\Route;
// Tour
Route::get('/faqs/','FaqController@index')->name('faq.search'); // Search

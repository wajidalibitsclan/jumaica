<?php
use Illuminate\Support\Facades\Route;

Route::post('/bulkEdit','TemplateController@bulkEdit')->name('template.admin.bulkEdit');

<?php

Route::get('/', function () {return view('welcome'); });

Route::resource('crud', 'crudController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/users', 'Admin\UserController@index');

#Rotas para a senha Única
Route::get('login', 'Auth\LoginController@redirectToProvider');
Route::get('login/senhaunica/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout');


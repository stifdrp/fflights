<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/users', 'Admin\UserController@index')->name('users');
Route::post('/admin/users/{id}/{profile}', 'Admin\ProfileController@toggleProfile')->name('toogle');

#Rotas para a senha Única
Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/senhaunica/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');




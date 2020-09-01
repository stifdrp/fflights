<?php

use Illuminate\Support\Facades\Route;


#Rotas para a senha Única
Route::get('login/senhaunica', 'Auth\LoginController@redirectToProvider');
Route::get('login/senhaunica/callback', 'Auth\LoginController@handleProviderCallback');


<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', 'HomeController@index')->name('home');

#Rotas para administradores
Route::get('/admin/users', 'Admin\UserController@index')->name('users');
Route::post('/admin/users/{id}/{profile}', 'Admin\ProfileController@toggleProfile')->name('toogle');

#Rotas para os Financeiros
Route::prefix('financer')->group( function() {
    Route::get('budgets', 'Financer\BudgetController@index')->name('budgets');
    Route::get('budget/create', 'Financer\BudgetController@create')->name('budget.create');
    Route::post('budget/store', 'Financer\BudgetController@store')->name('budget.store');
});

#Rotas para a senha Única
Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/senhaunica/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');




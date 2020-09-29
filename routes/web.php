<?php

use Illuminate\Support\Facades\Route;


Route::get('/home', 'HomeController@index')->name('home');
#Rotas para os tickets
Route::get('/solicitation/{order}/tickets/create', 'TicketController@create')->name('ticket.create');
Route::post('/solicitation/{order}/tickets/store', 'TicketController@store')->name('ticket.store');
Route::get('/solicitation/ticket/{ticket}/edit', 'TicketController@edit')->name('ticket.edit');
Route::put('/solicitation/ticket/{ticket}/edit', 'TicketController@update')->name('ticket.update');
Route::get('/solicitation/ticket/{ticket}/passport', 'TicketController@passportDownload')->name('ticket.passport.download');


##Solicitações
Route::get('/solicitation/create', 'OrderController@create')->name('order');
Route::post('/solicitation', 'OrderController@store')->name('order.store');
Route::get('/solicitation/{order}/edit', 'OrderController@edit')->name('order.edit');
Route::put('/solicitation/{order}', 'OrderController@update')->name('order.update');
Route::get('/solicitation/{order}', 'OrderController@show')->name('order.show');

Route::get('/solicitations', 'OrderController@index');
Route::get('/solicitations/my', 'OrderController@mySolicitations')->name('orders.my');


#Rotas para administradores
Route::get('/admin/users', 'Admin\UserController@index')->name('users');
Route::post('/admin/users/{id}/{profile}', 'Admin\ProfileController@toggleProfile')->name('toogle');

#Rotas para os Financeiros
Route::prefix('financer')->group( function() {
    Route::get('budgets', 'Financer\BudgetController@index')->name('budgets');
    Route::get('budget/create', 'Financer\BudgetController@create')->name('budget.create');
    Route::post('budget', 'Financer\BudgetController@store')->name('budget.store');
    Route::get('budget/{id}/edit', 'Financer\BudgetController@edit')->name('budget.edit');
    Route::put('budget/{id}', 'Financer\BudgetController@update')->name('budget.update');
});

#Rotas para a senha Única
Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/senhaunica/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');




<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Financer\TicketQuoteController;

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
#Rotas para os tickets
Route::get('/solicitation/{order}/tickets', 'TicketController@create')->name('ticket.create');
Route::post('/solicitation/{order}/tickets', 'TicketController@store')->name('ticket.store');
Route::get('/solicitation/ticket/{ticket}/quote', 'Financer\TicketQuoteController@quote')->name('ticket.quote');
Route::get('/solicitation/ticket/{ticket}/quote/{flightSegment}', 'Financer\TicketQuoteController@getFlightSegment')->name('ticket.fs.get');
Route::post('/solicitation/ticket/{ticket}/quote/{flightSegment}', [TicketQuoteController::class, 'quoteStore'])->name('ticket.fs');

// Route::put('/solicitation/ticket/{ticket}/quote/{flightSegment}', 'Financer\TicketQuoteController@quoteStore')->name('ticket.quote.store');
Route::get('/solicitation/ticket/{ticket}/edit', 'TicketController@edit')->name('ticket.edit');
Route::put('/solicitation/ticket/{ticket}', 'TicketController@update')->name('ticket.update');
Route::delete('/solicitation/ticket/{ticket}', 'TicketController@destroy')->name('ticket.destroy');
Route::get('/solicitation/ticket/{ticket}/passport', 'TicketController@passportDownload')->name('ticket.passport.download');

##Processar Solicitações
Route::get('/solicitation/{order}/tofinancer', 'OrderController@toFinancer')->name('order.financer');
Route::get('/solicitation/{order}/toElaboration', [OrderController::class, 'toElaboration'])->name('order.elaboration');
Route::get('/solicitation/{order}/inProgress', [OrderController::class, 'inProgress'])->name('order.inProgress');

##Solicitações
Route::get('/solicitation/create', 'OrderController@create')->name('order');
Route::post('/solicitation', 'OrderController@store')->name('order.store');
Route::get('/solicitation/{order}/edit', 'OrderController@edit')->name('order.edit');
Route::put('/solicitation/{order}', 'OrderController@update')->name('order.update');
Route::get('/solicitation/{order}', 'OrderController@show')->name('order.show');
Route::delete('/solicitation/{order}', 'OrderController@destroy')->name('order.destroy');



Route::get('/solicitations', 'OrderController@index')->name('order.list');
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
Route::get('login', [LoginController::class, 'redirectToProvider'])->name('login');
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
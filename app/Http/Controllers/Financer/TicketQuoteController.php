<?php

namespace App\Http\Controllers\Financer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketQuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware([ 'auth', 'can:financer']);
    }

    public function quote(Ticket $ticket)
    {
        if(!$ticket->order->inProgress()){
            return redirect()->route('order.show', ['order' => $ticket->order]);
        }
        return view('order.ticket.quote', ['ticket' => $ticket]);
    }

    public function quoteStore(Request $request, Ticket $ticket)
    {
        if(!$ticket->order->forQuote()){
            return redirect()->route('order.show', ['order' => $ticket->order]);
        }

        $validateData = $request->validate([
            'price' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/',
            'boardingTax' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/',
            'agencyTax' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/'
        ]);
        $price = $this->toMoney($request->input('price'));
        $boardingTax = $this->toMoney($request->input('boardingTax'));
        $agencyTax = $this->toMoney($request->input('agencyTax'));

        $ticket->price = $price;
        $ticket->boardingTax = $boardingTax;
        $ticket->agencyTax = $agencyTax;
        $ticket->save();
        return view('order.ticket.quote', ['ticket' => $ticket]);
    }

    protected function toMoney($amount){
        $money = str_replace('.','', $amount);
        $money = str_replace(',','.', $money);
        return $money;
    }
}

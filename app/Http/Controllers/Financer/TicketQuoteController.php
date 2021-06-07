<?php

namespace App\Http\Controllers\Financer;

use App\Http\Controllers\Controller;
use App\Models\FlightSegment;
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
        $ticket->flightSegments();
        return view('order.ticket.quote', ['ticket' => $ticket]);
    }

    public function getFlightSegment(Ticket $ticket, FlightSegment $flightSegment)
    {
        if ($ticket->flightSegments->contains($flightSegment)){
            return response()->json([
                'data' => $flightSegment,
                'ticket' => $ticket
            ]);
        }
    }

    public function quoteStore(Request $request, Ticket $ticket, FlightSegment $flightSegment)
    {
        if(!$ticket->order->inProgress()){
            return redirect()->route('order.show', ['order' => $ticket->order]);
        }

        $validateData = $request->validate([
            'price' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/',
            'boardingTax' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/',
            'agencyTax' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/',
            'discount' => 'required|regex:/((\d{1,3}\.?)+(,\d{2}))/'
        ]);
        $price = $this->toMoney($request->input('price'));
        $boardingTax = $this->toMoney($request->input('boardingTax'));
        $agencyTax = $this->toMoney($request->input('agencyTax'));
        $discount = $this->toMoney($request->input('discount'));

        $flightSegment->price = $price;
        $flightSegment->boardingTax = $boardingTax;
        $flightSegment->agencyTax = $agencyTax;
        $flightSegment->discount = $discount;
        $flightSegment->save();
        return view('order.ticket.quote', ['ticket' => $ticket]);
    }

    protected function toMoney($amount){
        $money = str_replace('.','', $amount);
        $money = str_replace(',','.', $money);
        return $money;
    }
}

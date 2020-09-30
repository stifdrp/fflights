<?php

namespace App\Http\Controllers;

use App\Order;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Order $order)
    {
        $this->authorize('create', [Ticket::class, $order]);
        return view('order.ticket.create', [
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Order $order, Request $request)
    {

        $this->authorize('create', [Ticket::class, $order]);
        $this->validateTicket();
        $ticket = new Ticket();
        $ticket->uspNumber = $request->input('uspNumber');
        $ticket->passangerFullName = $request->input('passangerFullName');
        $ticket->incomingFromAirportCode = strtoupper($request->input('incomingFromAirportCode'));
        $ticket->incomingToAirportCode = strtoupper($request->input('incomingToAirportCode'));
        $ticket->departDate = $request->input('departDate');
        $ticket->outcomingFromAirportCode = strtoupper($request->input('outcomingFromAirportCode'));
        $ticket->outcomingToAirportCode = strtoupper($request->input('outcomingToAirportCode'));
        $ticket->returnDate = $request->input('returnDate');
        $ticket->international = $request->input('international') ? True : False;
        if($request->input('international')) {
            if($request->file('passport')){
               $fileName = time().'_'.$request->file('passport')->getClientOriginalName();
               $ticket->passport = $request->file('passport')->storeAs('passports', $fileName);
            }else {
                return redirect()->back()->withInput()->withErrors('Não foi possível encontrar o arquivo');
            }
        }
        $ticket->order()->associate($order);
        $ticket->save();
        return redirect()
                ->route('order.show', [ 'order' => $order]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $this->authorize('userOrFinancer', $ticket);
        $ticket->order;
        return view('order.ticket.edit', [
            'ticket' => $ticket
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $this->validateTicket();
        $ticket->uspNumber = $request->input('uspNumber');
        $ticket->passangerFullName = $request->input('passangerFullName');
        $ticket->incomingFromAirportCode = strtoupper($request->input('incomingFromAirportCode'));
        $ticket->incomingToAirportCode = strtoupper($request->input('incomingToAirportCode'));
        $ticket->departDate = $request->input('departDate');
        $ticket->outcomingFromAirportCode = strtoupper($request->input('outcomingFromAirportCode'));
        $ticket->outcomingToAirportCode = strtoupper($request->input('outcomingToAirportCode'));
        $ticket->returnDate = $request->input('returnDate');
        $ticket->international = $request->input('international') ? True : False;
        if($request->input('international')) {
            if($request->file('passport')){
               Storage::delete([$ticket->passport]);
               $fileName = time().'_'.$request->file('passport')->getClientOriginalName();
               $ticket->passport = $request->file('passport')->storeAs('passports', $fileName);
            }else {
                return redirect()->back()->withInput()->withErrors('Não foi possível encontrar o arquivo');
            }
        }
        $ticket->save();
        return redirect()->route('order.show', ['order' => $ticket->order]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function passportDownload(Ticket $ticket)
    {
        $this->authorize('userOrFinancer', $ticket);
        return Storage::download($ticket->passport);
    }

    protected function validateTicket()
    {
        return request()->validate([
            'uspNumber'                 => 'nullable|integer',
            'passangerFullName'         => 'required|string|max:150',
            'incomingFromAirportCode'   => 'required|string|size:3',
            'incomingToAirportCode'     => 'required|string|size:3',
            'departDate'                => 'required|date',
            'outcomingFromAirportCode'  => 'required|string|size:3',
            'outcomingToAirportCode'    => 'required|string|size:3',
            'returnDate'                => 'required|date',
            'international'             => 'nullable|string',
            'passport'                  => 'required_if:international,==,True|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ],
        [
            'uspNumber.integer'                 => 'Tem que ser número',
            'passangerFullName.required'        => 'O nome do passageiro é obrigatório',
            'incomingFromAirportCode.required'  => 'O código de Aeroporto é obrigatório',
            'incomingToAirportCode.required'    => 'O código de Aeroporto é obrigatório',
            'outcomingFromAirportCode.required' => 'O código de Aeroporto é obrigatório',
            'outcomingToAirportCode.required'   => 'O código de Aeroporto é obrigatório',
            'incomingFromAirportCode.size'      => 'O código de Aeroporto tem que ter 3 digitos',
            'incomingToAirportCode.size'        => 'O código de Aeroporto tem que ter 3 digitos',
            'outcomingFromAirportCode.size'     => 'O código de Aeroporto tem que ter 3 digitos',
            'outcomingToAirportCode.size'       => 'O código de Aeroporto tem que ter 3 digitos',
            'departDate.required'               => 'A data de embarque é obrigatória',
            'returnDate.required'               => 'A data de embarque é obrigatória',
            'passport.required_if'              => 'Arquivo do passaporte é obrigatório (extensões permitidas pdf, jpg e png',
            'passport.mimes'                    => 'Arquivo inválido, extensões permitidas: pdf, jpg, png',
            ]
        );
    }

}

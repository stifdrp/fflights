<?php

namespace App\Http\Controllers;

use App\Models\FlightSegment;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if(isset($request->addmore)){
            foreach($request->addmore as $segment){
                $flightSegment = new FlightSegment();
                $flightSegment->toAirportCode = $segment['toAirportCode'];
                $flightSegment->fromAirportCode = $segment['fromAirportCode'];
                $flightSegment->departDate = $segment['departDate'];
                $flightSegment->departTime = $segment['departTime'];
                $ticket->flightSegments()->save($flightSegment);
            }
        };
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
        $this->authorize('update', $ticket);
        $ticket->order;
        $ticket->flightSegments;
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
        DB::beginTransaction();
        ###Atualizacao dos Trechos
        ##Removendo os trechos que existiam e foram apagados
        if(count($ticket->flightSegments) > 0){
            if(isset($request->addmore)){
                $remove = array_diff_key($ticket->flightSegments->toArray(), $request->addmore);
                foreach ($remove as $item){
                    $fs = FlightSegment::find($item['id']);
                    $fs->delete();
                }
            } else {
                $ticket->flightSegments()->delete();
            }
        }

        ##Atualizando os trechos que ja existiam e foram modificados
        $ticket->refresh();
        // dd($request->addmore);
        if (isset($request->addmore)){
            foreach($request->addmore as $item){
                if(isset($item['id'])){
                    $fs = FlightSegment::find($item['id']);
                } else {
                    $fs = new FlightSegment();
                    $fs->ticket_id = $ticket->id;
                }
                $fs->fromAirportCode = $item['fromAirportCode'];
                $fs->toAirportCode = $item['toAirportCode'];
                $fs->departDate = $item['departDate'];
                $fs->departTime = $item['departTime'];
                $fs->save();
            }
        }

        $ticket->refresh();
        $this->authorize('update', $ticket);
        $this->validateTicket();
        $ticket->uspNumber = $request->input('uspNumber');
        $ticket->passangerFullName = $request->input('passangerFullName');
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
        DB::commit();
                
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
        $this->authorize('delete', $ticket);
        Storage::delete($ticket->passport);
        $ticket->delete();
        return redirect()->route('order.show', $ticket->order);
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
            'addmore.*.fromAirportCode' => 'required|string|size:3',
            'addmore.*.toAirportCode'   => 'required|string|size:3',
            'addmore.*.departDate'      => 'required|date',
            'addmore.*.departTime'      => 'required|date_format:H:i',
            'international'             => 'nullable|string',
            'passport'                  => 'required_if:international,==,True|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ],
        [
            'uspNumber.integer'                     => 'Tem que ser número',
            'passangerFullName.required'            => 'O nome do passageiro é obrigatório',
            'addmore.*.fromAirportCode.required'    => 'O código de Aeroporto é obrigatório',
            'addmore.*.toAirportCode.required'      => 'O código de Aeroporto é obrigatório',
            'addmore.*.fromAirportCode.size'        => 'O código de Aeroporto tem que ter 3 digitos',
            'addmore.*.toAirportCode.size'          => 'O código de Aeroporto tem que ter 3 digitos',
            'departDate.required'                   => 'A data de embarque é obrigatória',
            'departTime.required'                   => 'A hora do embarque é obrigatória',
            'passport.required_if'                  => 'Arquivo do passaporte é obrigatório (extensões permitidas pdf, jpg e png',
            'passport.mimes'                        => 'Arquivo inválido, extensões permitidas: pdf, jpg, png',
            ]
        );
    }

}

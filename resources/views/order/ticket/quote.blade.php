@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box justify-content-center container-sm">
    <div class="box-header with-border d-flex justify-content-between">
        <h4 class="box-title">{{$ticket->order->description}}</h4>
    </div>

    <div class="container">
        <fieldset>
            <div class="row">
                <h6>Identificação</h6>
            </div>

            <div class="row">
                <div class="col-4">
                    <p><b>Número USP: </b>{{ $ticket->uspNumber ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Nome do passageiro:</b> {{ $ticket->passangerFullName ?? ''}}</p>
                </div>
            </div>

            <div class="row">
                <h6>Dados para chegada</h6>
            </div>
            <div class="row">
                <div class="col">
                    <p><b>Aeroporto de saída:</b> {{ $ticket->incomingFromAirportCode ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Aeroporto de chegada:</b> {{ $ticket->incomingToAirportCode ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Data de embarque:</b> {{ date('d/m/Y', strtotime($ticket->departDate)) ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Hora de embarque:</b> {{ date('H:i', strtotime($ticket->departDate)) ?? ''}}</p>
                </div>
            </div>

            <div class="row">
                <h6>Dados para saída</h6>
            </div>
            <div class="row">
                <div class="col">
                    <p><b>Aeroporto de saída:</b> {{ $ticket->outcomingFromAirportCode ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Aeroporto de chegada:</b> {{ $ticket->outcomingToAirportCode ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Data de embarque:</b> {{ date('d/m/Y', strtotime($ticket->returnDate)) ?? ''}}</p>
                </div>
                <div class="col">
                    <p><b>Hora de embarque:</b> {{ date('H:i', strtotime($ticket->returnDate)) ?? ''}}</p>
                </div>
            </div>

            <div class="row">
                <h6>Dados adicionais</h6>
            </div>
            <div class="row">
                <div class="col">
                    <p><b>Passagem internacional:</b> {{ $ticket->international ? 'Sim' : 'Não'}}</p>
                </div>
                @isset($ticket->passport)
                <div class="col">
                    <a href="{{route('ticket.passport.download', ['ticket' => $ticket])}}" class="btn btn-primary active" role="button" aria-pressed="true">Passaporte</a>
                </div>
                @endisset
            </div>


        </fieldset>
    </div>

    <form action="{{ route('ticket.quote', ['ticket' => $ticket]) }}" method="post">
        @method('PUT')
        @csrf
        @can('financer')
            @include('order.ticket.financial_form');
        @endcan
    </form>

</div>

</div>

@endsection

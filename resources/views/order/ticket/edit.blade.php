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
        <h3 class="box-title">{{$ticket->order->description}}</h3>
        @isset($ticket)
            @if($ticket->order->status == 'E')
            <div class="box-tools">
                <form
                    class="d-inline"
                    action="{{ route('ticket.destroy', ['ticket' => $ticket ])}}"
                    method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir?')"
                >
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Apagar</button>
                </form>
            </div>
            @endif
        @endisset
    </div>


    <form action="{{ route('ticket.update', ['ticket' => $ticket]) }}" enctype="multipart/form-data" method="post">
        @method('PUT')
        @csrf
        @include('order.ticket.form')
    </form>

</div>

</div>

@endsection

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
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$ticket->order->description}}</h3>
        </div>
        <form action="{{ route('ticket.update', ['ticket' => $ticket]) }}" enctype="multipart/form-data" method="post">
            @method('PUT')
            @csrf
            @include('order.ticket.form')
        </form>

    </div>
</div>

</div>

@endsection

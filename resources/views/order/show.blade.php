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
            <h3 class="box-title">Solicitar Passagens</h3>
        </div>

        <fieldset disabled>
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control"
                    id="descripton" name="description" value="{{ $order->description }}">
                </div>

                <div class="row justify-content-between no-gutters">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Verba</label>
                            <select class="form-control" name="budget">
                                <option value="{{$order->budget->id}}"  selected="selected">{{$order->budget->title}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5 ">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control"
                                id="status" name="status" value="{{ $order->status }}">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </fieldset>

        @if (count($order->tickets) > 0 )
            Passagens:
            <ul>
            @foreach ($order->tickets as $ticket )
                <li><a href=""> {{$ticket->passangerFullName}}</a></li>
            @endforeach
            </ul>
        @endif

        <hr/>
        <div class="box-footer">
            <a href="{{ route('order.tickets', ['order' => $order ]) }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Adicionar passagem</a>
        </div>

    </div>

</div>

@endsection


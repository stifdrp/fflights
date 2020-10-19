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
        <h3 class="box-title">Solicitar Passagens</h3>
        @isset($order)
            @if($order->inElaboration())
                <div class="box-tools">
                    <form
                        action="{{ route('order.destroy', ['order' => $order ])}}"
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
                            id="status" name="status" value="{{ $order->statusName }}">
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
            <li><a href="
                    @if ($order->inElaboration())
                        {{route('ticket.edit', ['ticket' => $ticket ])}}
                    @elseif ($order->inProgress())
                        {{route('ticket.quote', ['ticket' => $ticket ])}}
                    @endif
                "> {{$ticket->passangerFullName}}</a></li>
        @endforeach
        </ul>
    @endif

    <hr/>
    <div class="box-footer">
        <div class="row justify-content-between no-gutters">
            @isset($order)
                @if($order->inElaboration())
                    <div class="col-auto mr-auto mx-auto">
                        <a href="{{ route('ticket.create', ['order' => $order ]) }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">+ passagem</a>
                    </div>
                    <div class="col-auto mr-auto mx-auto">
                        <a href="{{ route('order.financer', [ 'order' => $order]) }}" class="btn btn-success btn-lg w-auto" role="button">Enviar</a>
                    </div>
                @endif
                @can('financer')
                    @if($order->forQuote())
                        <div class="col-auto mr-auto mx-auto">
                            <a href="{{ route('ticket.create', ['order' => $order ]) }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Cotar</a>
                        </div>
                    @endif
                    @if($order->inProgress())
                    <div class="col-auto mr-auto mx-auto">
                        <a href="{{ route('ticket.create', ['order' => $order ]) }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Emitir</a>
                    </div>
                @endif
                @endcan
            @endisset
            <div class="col-auto mr-auto mx-auto">
                <a href="{{ route('orders.my') }}" class="btn btn-info btn-lg" role="button">Voltar</a>
            </div>
        </div>
    </div>



</div>

@endsection


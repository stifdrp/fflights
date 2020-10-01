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
        <h3 class="box-title">Editar Solicitação</h3>
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
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form role="form" action="{{ route('order.update', ['order' => $order ] ) }}" method="POST">
        @method('PUT')
        @csrf
        @include('order.form')
    </form>
</div>

</div>

@endsection

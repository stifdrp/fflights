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
            <h3 class="box-title">Solicitação</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="{{ route('order.store') }}" method="POST">
            @csrf
            @include('order.form')
        </form>
    </div>
</div>

</div>

@endsection


@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
<div class="box">
    <div class="box-header d-flex justify-content-between" >
        <h3 class="box-title">Solicitações</h3>
        <div class="box-tools">
            <div class="input-group input-group-sm hidden-xs" style="width: 200px;">
                <form action="" class="d-flex">
                    <input type="text" name="search" class="form-control pull-right" placeholder="Search">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
          </div>
    </div>
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>Descrição</th>
                    <th>Solicitante</th>
                    <th>Verba</th>
                    <th>Estatus</th>
                    <th>Data da solicitação</td>
                </tr>

                @foreach ($orders as $order)

                <tr>
                    <td>
                        {{-- <a href="{{ route('order.edit', ['id' => $order->id]) }}">{{$order->description}}</a> --}}
                        {{$order->description}}
                    </td>
                    <td>
                        {{$order->user->id}} - {{$order->user->name}}
                    </td>
                    <td>
                        {{$order->budget->title}}
                    </td>
                    <td>
                        {{$order->status}}
                    </td>
                    <td>
                        {{ date('d/m/Y', strtotime($order->created_at)) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}

    </div>
</div>
@endsection

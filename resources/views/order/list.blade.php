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
    @isset($status)
    <div class="row justify-content-md-center py-3 px-lg-5 ">
        <form action="{{ route('order.list')}}" method="get">
            @foreach($status as $key => $value)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="filter[]" value="{{$key}}"
                @if (in_array($key, $filter))
                    checked
                @endif>
                <label class="form-check-label" for="inlineCheckbox1">{{$value}}</label>
            </div>
            @endforeach
            <button type="submit" class="btn btn-secondary btn-sm">Filtrar</button>
        </form>
    </div>
    @endisset
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>Descrição</th>
                    <th>Solicitante</th>
                    <th>Verba</th>
                    <th>Estatus</th>
                    <th>Data da solicitação</td>
                    <th>Ações</td>
                </tr>

                @foreach ($orders as $order)

                <tr>
                    <td>
                        <a href="{{ route('order.show', ['order' => $order]) }}">{{$order->description}}</a>
                    </td>
                    <td>
                        {{$order->user->id}} - {{$order->user->name}}
                    </td>
                    <td>
                        {{$order->budget->title}}
                    </td>
                    <td>
                        {{$order->statusName}}
                    </td>
                    <td>
                        {{ date('d/m/Y', strtotime($order->created_at)) }}
                    </td>
                    <td>
                        <a href="{{ route('order.edit', ['order' => $order]) }}"><i class="fas fa-edit"></i></a>
                        <form
                            class="d-inline"
                            action="{{ route('order.destroy', ['order' => $order ])}}"
                            method="POST"
                            onsubmit="return confirm('Tem certeza que deseja excluir?')"
                        >
                            @method('DELETE')
                            @csrf
                            <button type="submit" style="background: none; padding: 0px; border: none; text-decoration: none"><i class="fas fa-times"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->withQueryString()->links() }}

    </div>
</div>
@endsection

@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
<div class="box">
    <div class="box-header d-flex justify-content-between" >
        <h3 class="box-title">Verbas</h3>
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
                    <th>Título</th>
                </tr>

                @foreach ($budgets as $budget)
                <tr>
                    <td>
                        {{$budget->id}}
                    </td>
                    <td>
                        {{$budget->title}}
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $budgets->links() }}

    </div>
</div>
@endsection

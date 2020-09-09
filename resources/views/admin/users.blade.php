@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
        <div class="box">
            <div class="box-header" style="display: flex; justify-content: space-between;}">
                <h3 class="box-title">Lista de Usuários</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                      <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
            </div>
            <div >

                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Nome</th>
                            <th>Perfis</th>
                            <th>Gerenciar Perfis</th>
                        </tr>

                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{-- @foreach ($user->profiles()->pluck('description') as $profile )
                                        {{ $profile }}
                                    @endforeach --}}
                                    {{ implode( ', ', $user->profiles()->pluck('description')->toArray()) }}
                                </td>
                                <td>
                                    <a href="" class="btn btn-md btn-info">Perfis</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>


    </div>






@endsection

@section('footer')

@endsection





@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
        <div class="box">
            <div class="box-header" style="display: flex; justify-content: space-between;}">
                <h3 class="box-title">Lista de Usuários</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                        <form action="">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                  </div>
            </div>
            <div >

                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Numero USP</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Administrador</th>
                            <th>Financeiro</th>
                        </tr>

                        @foreach ($users as $user)
                        <tr>
                            <td>
                                {{$user->id}}
                            </td>
                            <td>
                                {{$user->name}}
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>
                                    {{-- @foreach ($user->profiles()->pluck('description') as $profile )
                                        {{ $profile }}
                                    @endforeach --}}
                                    {{-- {{ implode( ', ', $user->profiles()->pluck('description')->toArray()) }} --}}
                                        @csrf
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <form action="{{ route('toogle', ['id' => $user->id, 'profile' => 'Admin' ]) }}" method="POST">
                                                    @csrf
                                                  <input type="checkbox"
                                                    {{($user->profiles->where('description', 'Admin')
                                                        ->count() > 0) ? 'checked' : ''}}
                                                  onChange="submit()">
                                                </form>
                                              </div>
                                        </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <form action="{{ route('toogle', ['id' => $user->id, 'profile' => 'Financer' ]) }}" method="POST">
                                            @csrf
                                                <input type="checkbox"
                                                {{($user->profiles->where('description', 'Financer')
                                                    ->count() > 0) ? 'checked' : ''}}
                                                onChange="submit()">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}

            </div>
        </div>


    </div>






@endsection

@section('footer')

@endsection


@section('javascripts_bottom')

@endsection


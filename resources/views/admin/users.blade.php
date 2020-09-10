@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
<div class="box">
    <div class="box-header d-flex justify-content-between" >
        <h3 class="box-title">Lista de Usuários</h3>
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
                    <th>Numero USP</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th class="text-center">Administrador</th>
                    <th class="text-center">Financeiro</th>
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
                    <td class="text-center">
                            {{-- @foreach ($user->profiles()->pluck('description') as $profile )
                                {{ $profile }}
                            @endforeach --}}
                            {{-- {{ implode( ', ', $user->profiles()->pluck('description')->toArray()) }} --}}
                            @csrf
                            <div class="form-group">
                                <form action="{{ route('toogle', ['id' => $user->id, 'profile' => 'Admin' ]) }}" method="POST">
                                    @csrf
                                    <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id={{$user->id}}
                                        {{($user->profiles->where('description', 'Admin')
                                            ->count() > 0) ? 'checked' : ''}}
                                    onChange="submit()">
                                    <label class="custom-control-label" for={{$user->id}}></label>
                                    </div>
                                </form>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-group">
                                <form action="{{ route('toogle', ['id' => $user->id, 'profile' => 'Financer' ]) }}" method="POST">
                                    @csrf
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"  class="custom-control-input" id={{ $user->id . 'f'}}
                                            {{($user->profiles->where('description', 'Financer')
                                                ->count() > 0) ? 'checked' : ''}}
                                            onChange="submit()">
                                            <label class="custom-control-label" for={{$user->id . 'f'}}></label>
                                        </div>
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




@endsection


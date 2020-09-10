<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware([ 'auth', 'can:admin']);
    }

    //Listagem de Usuários
    public function index()
    {
        //Seleciona os usuários junto com o(s) seu(s) perfil(is)
        $userList = User::exclude( [
            'password',
            'email_verified_at',
            'remember_token',
            'created_at',
            'updated_at'
        ])->orderBy('name')->with('profiles')->paginate(5);;

        return view('admin.users', [
            'users' => $userList,
        ]);
    }
}

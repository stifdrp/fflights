<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        //Login temporario de usuario teste

            // $user = User::find('5542290'); //usuario financeiro e admin
            // // $user = User::find('59020429'); //usuario financeiro apenas
            // // $user = User::find('9206585'); //usuario apenas

            // Auth::login($user, true);
            // return redirect()->route('home');


        // Procedimento correto
        return Socialite::driver('senhaunica')->redirect();
    }

    public function handleProviderCallback()
    {

        $userSenhaUnica = Socialite::driver('senhaunica')->user();
        $user = User::where('id',$userSenhaUnica->codpes)->first();

        if (is_null($user)) $user = new User;

        // bind do dados retornados
        $user->id = $userSenhaUnica->codpes;
        $user->email = $userSenhaUnica->email;
        $user->name = $userSenhaUnica->nompes;
        $user->save();
        Auth::login($user, true);
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');

    }
}

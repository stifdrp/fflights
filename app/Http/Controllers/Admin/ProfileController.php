<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware([ 'auth', 'can:admin']);
    }


    public function toggleProfile($id, $profile, Request $request)
    {
        $user = User::find($id);
        $profile = Profile::where('description', $profile)->first();
        // dd($request->url());
        if($user && $profile){
            $user->profiles()->toggle($profile->id);
            // return redirect()->route('users')->withPath()->with('status', 'Success');
            return redirect()->back()->with('status', 'Success');
        } else {
            return redirect()->back()->with('status', 'Não foi possível a alteração');
        }
    }
}

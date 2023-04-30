<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController
{
    public function login(Request $request){

        if (Auth::check()){
            return redirect(route('data'));
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)){
            Auth::login($user);
            return redirect()->route('data');
        }
        else{
            return redirect()->route('login');
        }
    }
}
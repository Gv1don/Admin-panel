<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegistrationController
{
    public function registration(Request $request){   

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if($user){
            return redirect()->route('registration');
        };

        $password = $request->input('password');
        $confirm = $request->input('confirm-password');

        if($password == $confirm){
            $user = new User();
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            Auth::logout();
            return redirect()->route('login');
        }

        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'password'=> ['required','min:3', 'confirmed'],
            'email' => ['required', 'email','max:255', 'unique:users'],
        ]);

        $user = User::create($fields);
        Auth::login($user);
        return redirect()->route('home');
    }

    // login
    public function login(Request $request) {
        //VAlidate
        $fields = $request ->validate([
            'email' => ['required', 'email','max:255'],
            'password' => ['required']
        ]);

        // dd($request);
        if(Auth::attempt($fields, $request->remember)) {
            return redirect()->intended();
        } else {
            return back()->withErrors([
                'failed' => 'wrong password or email'
            ]);
        }
    }
}

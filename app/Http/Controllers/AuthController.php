<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validation, hashing password and user creation logic

        return $user;
    }

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed, redirect to the dashboard
        return redirect()->intended('dashboard');
    } else {
        // Authentication failed, redirect back to the login form
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}


    public function logout(Request $request)
    {
        // revoking user's token
        $request->user()->tokens()->delete();

        return response('Loggedout', 200);
    }
}

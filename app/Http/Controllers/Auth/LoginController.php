<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function showLogin()
    {
        $title = 'Silakan login terlebih dahulu';
        return view('auth.login', compact('title'));
    }

    protected function handleLogin(Request $request)
    {
        $credentials = $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    protected function handleLogout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah keluar');
    }
}

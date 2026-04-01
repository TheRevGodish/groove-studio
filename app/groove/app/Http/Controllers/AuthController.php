<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function showLogin() {
        return view('login');
    }

    public function login(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $default = Auth::user()->is_admin
                ? route('admin.dashboard')
                : route('client.dashboard');

            return redirect()->intended($default);
        }

        return back()->withErrors([
            'email' => 'Provided credentials are incorrect.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

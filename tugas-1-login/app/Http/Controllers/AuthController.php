<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            // Cegah session fixation
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Pesan sengaja tidak menyebut mana yang salah (username atau password)
        return back()
            ->withInput($request->only('username'))
            ->withErrors(['login' => 'Username atau password salah.']);
    }

    public function dashboard(): View
    {
        return view('dashboard', ['user' => Auth::user()]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

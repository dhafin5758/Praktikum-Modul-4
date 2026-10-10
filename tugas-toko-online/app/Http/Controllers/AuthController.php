<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // cegah session fixation

            return redirect()->intended('/');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['login' => 'Username atau password salah.']);
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', 'unique:users,email'],
            'username'     => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'password'     => ['required', 'string', 'min:6', 'confirmed'],
            'no_hp'        => ['nullable', 'string', 'max:15'],
            'alamat'       => ['nullable', 'string'],
        ]);

        $data['id_user'] = User::buatId();

        $user = User::create($data); // password di-hash oleh cast 'hashed'

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('pesan', 'Pendaftaran berhasil. Selamat datang, ' . $user->nama_lengkap . '!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

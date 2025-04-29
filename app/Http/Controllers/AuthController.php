<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('Backend.Auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Mencoba login dengan kredensial
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Jika sukses login, arahkan ke dashboard sesuai dengan role
            $user = Auth::user();
            if ($user->role == 'owner') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role == 'kasir') {
                return redirect()->intended('/dashboard');
            }
        }

        // Jika gagal login, kembali ke halaman login dengan pesan error
        return redirect()->back()->withErrors(['login_error' => 'Username atau Password salah.']);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
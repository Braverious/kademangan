<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (Auth::check()) {
            return redirect()->intended('admin/dashboard');
        }
        return view('auth.login');
    }

    public function aksi_login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Laravel akan mencari di tabel 'user' (sesuai isi Model) 
        // berdasarkan 'username' dan mencocokkan 'password'-nya
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // 1. Keluarkan user dari status autentikasi Laravel
        Auth::logout();

        // 2. Hancurkan semua data session yang tersisa
        $request->session()->invalidate();

        // 3. Buat ulang token CSRF baru demi keamanan
        $request->session()->regenerateToken();

        // 4. Arahkan kembali ke halaman home (root)
        return redirect()->route('home');
    }
}

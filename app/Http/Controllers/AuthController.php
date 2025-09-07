<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    // Memproses upaya login
    public function store(Request $request) // <-- NAMA METODE DIPERBAIKI DARI 'login' MENJADI 'store'
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke dashboard admin jika rolenya admin
            if (Auth::user()->role === 'admin') {
                // Ganti '/admin/dashboard' dengan rute dashboard Anda yang sebenarnya
                return redirect()->intended('/admin/dashboard'); 
            }

            // Redirect ke halaman lain untuk user biasa
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    /**
     * Memproses dan menyimpan user baru.
     */
    public function register(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' butuh input 'password_confirmation'
        ]);

        // 2. Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // Role default akan 'user' sesuai migrasi
        ]);

        // 3. Login user yang baru dibuat
        Auth::login($user);

        // 4. Redirect ke halaman home
        return redirect('/');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
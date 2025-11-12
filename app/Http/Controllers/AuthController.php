<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Attempt login dengan remember me
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Log aktivitas login (opsional)
            Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role->name,
            ]);

            // Redirect berdasarkan role
            if ($user->isSuperAdmin()) {
                return redirect()->intended('dashboard')->with('success', 'Selamat datang, Super Admin!');
            } elseif ($user->isAdmin()) {
                return redirect()->intended('dashboard')->with('success', 'Selamat datang, Admin!');
            }

            // Default redirect
            return redirect()->intended('dashboard');
        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log aktivitas logout (opsional)
        Log::info('User logged out', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        return view('admin.dashboard', [
            'user' => $user,
            'role' => $user->role,
        ]);
    }
}

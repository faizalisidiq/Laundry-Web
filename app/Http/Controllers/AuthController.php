<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login()
    {
        return view('auth.login');
    }

    function authenticate(Request $request)
    {
        // Validasi input dengan custom error message
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        // Login hanya dengan email & password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Validasi name
            if ($user->name !== $request->name) {
                Auth::logout();
                return back()->withErrors(['name' => 'Nama tidak sesuai dengan akun.'])->withInput();
            }

            // Validasi role
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'Role tidak sesuai dengan akun.'])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Jika email/password salah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email', 'name', 'role'));
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }

    function dashboard()
    {
        return view('admin.dashboard');
    }
}

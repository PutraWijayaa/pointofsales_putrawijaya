<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $request->session()->regenerate();

            // Redirect berdasarkan role
            $roles = $user->roles()->pluck('name')->toArray();

            if (in_array('pimpinan', $roles)) {
                return redirect()->route('pimpinan.dashboard');
            } elseif (in_array('admin', $roles)) {
                return redirect()->route('admin.dashboard');
            } elseif (in_array('kasir', $roles)) {
                return redirect()->route('kasir.dashboard');
            }

            return redirect()->intended('login');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

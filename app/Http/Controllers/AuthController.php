<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

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
            Alert::success('Berhasil Login', 'Selamat datang, ' . $user->name . '!');


            // Redirect berdasarkan role
            $roles = $user->roles()->pluck('name')->toArray();

            if (in_array('pimpinan', $roles)) {
                return redirect()->route('pimpinan.dashboard');
            } elseif (in_array('admin', $roles)) {
                return redirect()->route('admin.dashboard');
            } elseif (in_array('kasir', $roles)) {
                return redirect()->route('kasir.dashboard');
            }

            Alert::success('Success Title', 'Success Message');
            return redirect()->intended('login');
        }

        Alert::error('Gagal Login', 'Email atau password salah.');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Berhasil Logout', 'Anda telah berhasil logout.');
        return redirect('/');
    }
}

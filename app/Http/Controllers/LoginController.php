<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', [
            'judul' => 'Login',
        ]);
    }
    public function authenticateBackend(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            if ($user->status == 0) {
                Auth::guard('admin')->logout();
                return back()->with('error', 'User belum aktif');
            }
            $request->session()->regenerate();
            return redirect()->intended(route('backend.beranda'));
        }
        return back()->with('error', 'Login Gagal');
    }

    public function logoutBackend()
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('backend.login'));
    }
}

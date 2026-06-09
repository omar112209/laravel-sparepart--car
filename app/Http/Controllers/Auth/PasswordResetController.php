<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // ========== FORGOT PASSWORD (Backend Admin) ==========
    public function showForgotBackend()
    {
        return view('backend.v_login.forgot', [
            'judul' => 'Lupa Password - Admin'
        ]);
    }

    public function sendResetLinkBackend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
        ]);

        $user = User::where('email', $request->email)->whereIn('role', [0, 1])->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan atau bukan akun admin.');
        }

        $token = Str::random(60);
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => bcrypt($token), 'created_at' => now()]
        );

        $user->notify(new ResetPasswordNotification($token));

        return back()->with('success', 'Tautan reset password telah dikirim ke email Anda.');
    }

    // ========== FORGOT PASSWORD (Frontend Customer) ==========
    public function showForgotCustomer()
    {
        return view('v_customer.forgot', [
            'judul' => 'Lupa Password'
        ]);
    }

    public function sendResetLinkCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
        ]);

        $user = User::where('email', $request->email)->where('role', 2)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan atau bukan akun customer.');
        }

        $token = Str::random(60);
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => bcrypt($token), 'created_at' => now()]
        );

        $user->notify(new ResetPasswordNotification($token));

        return back()->with('success', 'Tautan reset password telah dikirim ke email Anda.');
    }

    // ========== RESET PASSWORD ==========
    public function showResetForm(Request $request, $token)
    {
        return view('v_customer.reset', [
            'token' => $token,
            'email' => $request->email,
            'judul' => 'Reset Password'
        ]);
    }

    public function showResetFormBackend(Request $request, $token)
    {
        return view('backend.v_login.reset', [
            'token' => $token,
            'email' => $request->email,
            'judul' => 'Reset Password - Admin'
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $record = \DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !password_verify($request->token, $record->token)) {
            return back()->with('error', 'Token reset password tidak valid atau sudah kadaluwarsa.');
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->with('error', 'Token reset password sudah kadaluwarsa. Silakan minta ulang.');
        }

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        if ($user->role == 2) {
            return redirect()->route('customer.login')->with('success', 'Password berhasil direset. Silakan login.');
        }

        return redirect()->route('backend.login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}

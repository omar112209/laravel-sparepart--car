@extends('v_layouts.app')
@section('content')
<style>
.auth-wrap { min-height: calc(100vh - 180px); display: flex; align-items: center; justify-content: center; padding: 40px 16px; }
.auth-card { position: relative; width: 100%; max-width: 420px; }
.auth-card-inner { position: relative; background: var(--color-dark-3); border-radius: 20px; padding: 40px 36px; border: 1px solid var(--color-border); overflow: hidden; }
.auth-card-inner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, var(--color-red-primary), transparent); }
.auth-input { width: 100%; padding: 14px 16px; background: var(--color-dark-2); border: 1.5px solid var(--color-border); border-radius: 12px; color: var(--color-text); font-size: 14px; outline: none; transition: all 0.25s; }
.auth-input:focus { border-color: var(--color-red-primary); box-shadow: 0 0 0 4px rgba(200,16,46,0.08); }
.auth-input::placeholder { color: var(--color-text-3); font-size: 13px; }
.auth-label { display: block; font-family: var(--font-mono); font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; color: var(--color-text-3); }
.btn-google { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 13px 20px; border-radius: 12px; font-size: 14px; font-weight: 500; background: var(--color-dark-2); border: 1.5px solid var(--color-border); color: var(--color-text-2); cursor: pointer; transition: all 0.25s; text-decoration: none; }
.btn-google:hover { border-color: var(--color-border-red); background: var(--color-steel); color: var(--color-text); }
.auth-divider { position: relative; text-align: center; margin: 28px 0; }
.auth-divider::before { content: ''; position: absolute; left: 0; right: 0; top: 50%; height: 1px; background: var(--color-border); }
.auth-divider span { position: relative; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: var(--color-dark-3); border: 1px solid var(--color-border); color: var(--color-text-3); font-size: 10px; font-family: var(--font-mono); letter-spacing: 1px; }
.auth-link { color: var(--color-text-3); font-size: 13px; text-align: center; margin-top: 24px; }
.auth-link a { color: var(--color-red-primary); font-weight: 600; text-decoration: none; transition: color 0.2s; }
.auth-link a:hover { color: var(--color-text); }
.error-box { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; background: rgba(200,16,46,0.08); border: 1px solid rgba(200,16,46,0.2); color: #f87171; animation: fadeUp 0.4s ease both; }
.logo-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; background: linear-gradient(135deg, var(--color-red-primary), var(--color-red-dark)); box-shadow: 0 12px 40px rgba(200,16,46,0.25); }
.logo-icon i { color: #fff; }
</style>

<div class="auth-wrap">
    <div class="auth-card" style="animation:fadeUp 0.5s ease both;">
        <div class="auth-card-inner">
            <div class="logo-icon"><i class="fa fa-user-circle"></i></div>
            <h1 class="font-display text-[28px] font-extrabold tracking-[1.5px] uppercase text-center m-0 mb-1" style="color:var(--color-text);">Masuk</h1>
            <p class="text-center text-[13px] mb-7" style="color:var(--color-text-3);">Silakan masuk ke akun Anda</p>

            @if(session('error'))
            <div class="error-box"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            <form action="{{ route('customer.login') }}" method="post">
                @csrf
                <div class="mb-5">
                    <label class="auth-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="auth-input" placeholder="contoh@email.com">
                    @error('email')<div class="text-[12px] mt-1.5" style="color:#f87171;">{{ $message }}</div>@enderror
                </div>
                <div class="mb-6">
                    <label class="auth-label">Password</label>
                    <input type="password" name="password" required class="auth-input" placeholder="••••••••">
                    @error('password')<div class="text-[12px] mt-1.5" style="color:#f87171;">{{ $message }}</div>@enderror
                </div>
                <div class="text-right mb-4">
                    <a href="{{ route('customer.password.request') }}" class="text-[12px] transition-all" style="color:var(--color-text-3);text-decoration:none;" onmouseover="this.style.color='var(--color-red-primary)'" onmouseout="this.style.color='var(--color-text-3)'"><i class="fa fa-lock"></i> Lupa Password?</a>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl text-white font-display font-bold text-base tracking-[1.5px] uppercase border-0 cursor-pointer transition-all btn-loading-click" style="background:var(--color-red-primary);" onmouseover="this.style.background='var(--color-red-dark)'" onmouseout="this.style.background='var(--color-red-primary)'"><i class="fa fa-sign-in"></i> Masuk</button>
            </form>

            <div class="auth-divider"><span>ATAU</span></div>

            <a href="{{ route('auth.redirect') }}" class="btn-google">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Masuk dengan Google
            </a>

            <div class="auth-link">Belum punya akun? <a href="{{ route('customer.register') }}">Daftar Sekarang</a></div>
        </div>
    </div>
</div>
@endsection

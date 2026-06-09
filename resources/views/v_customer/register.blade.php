@extends('v_layouts.app')
@section('content')
<style>
.auth-wrap { min-height: calc(100vh - 180px); display: flex; align-items: center; justify-content: center; padding: 40px 16px; }
.auth-card { position: relative; width: 100%; max-width: 460px; }
.auth-card-inner { position: relative; background: var(--color-dark-3); border-radius: 20px; padding: 40px 36px; border: 1px solid var(--color-border); overflow: hidden; }
.auth-card-inner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, var(--color-red-primary), transparent); }
.auth-input { width: 100%; padding: 14px 16px; background: var(--color-dark-2); border: 1.5px solid var(--color-border); border-radius: 12px; color: var(--color-text); font-size: 14px; outline: none; transition: all 0.25s; }
.auth-input:focus { border-color: var(--color-red-primary); box-shadow: 0 0 0 4px rgba(200,16,46,0.08); }
.auth-input::placeholder { color: var(--color-text-3); font-size: 13px; }
.auth-label { display: block; font-family: var(--font-mono); font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; color: var(--color-text-3); }
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
            <div class="logo-icon"><i class="fa fa-user-plus"></i></div>
            <h1 class="font-display text-[28px] font-extrabold tracking-[1.5px] uppercase text-center m-0 mb-1" style="color:var(--color-text);">Daftar</h1>
            <p class="text-center text-[13px] mb-7" style="color:var(--color-text-3);">Buat akun baru untuk mulai berbelanja</p>

            @if($errors->any())
            <div class="error-box"><i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <form action="{{ route('customer.register') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label class="auth-label">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="auth-input" placeholder="Nama Anda">
                </div>
                <div class="mb-4">
                    <label class="auth-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="auth-input" placeholder="contoh@email.com">
                </div>
                <div class="mb-4">
                    <label class="auth-label">No. HP</label>
                    <input type="text" name="hp" value="{{ old('hp') }}" class="auth-input" placeholder="08xxxxxxxxxx">
                </div>
                <div class="flex gap-3">
                    <div class="flex-1 mb-4">
                        <label class="auth-label">Password</label>
                        <input type="password" name="password" required class="auth-input" placeholder="••••••••">
                    </div>
                    <div class="flex-1 mb-4">
                        <label class="auth-label">Konfirmasi</label>
                        <input type="password" name="password_confirmation" required class="auth-input" placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl text-white font-display font-bold text-base tracking-[1.5px] uppercase border-0 cursor-pointer transition-all btn-loading-click" style="background:var(--color-red-primary);" onmouseover="this.style.background='var(--color-red-dark)'" onmouseout="this.style.background='var(--color-red-primary)'"><i class="fa fa-user-plus"></i> Daftar</button>
            </form>

            <div class="auth-link">Sudah punya akun? <a href="{{ route('customer.login') }}">Masuk</a></div>
        </div>
    </div>
</div>
@endsection

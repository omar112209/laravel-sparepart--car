<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_mazteach.jpeg') }}">
    <title>Reset Password - MaztechGarage</title>
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        body { background: #1a1a2e; }
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); }
        .auth-box { width: 100%; max-width: 420px; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5); background: #1e2a3a !important; border: 1px solid rgba(255, 255, 255, 0.08) !important; }
        .auth-header { background: #000; padding: 24px 20px 16px; text-align: center; }
        .auth-header-img { width: 160px; height: 160px; object-fit: contain; object-position: center; display: block; margin: 0 auto; }
        .auth-header h4 { color: #fff; margin: 10px 0 4px 0; font-size: 18px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .auth-header p { color: rgba(255, 255, 255, 0.5); font-size: 12px; margin: 0; letter-spacing: 1px; }
        .auth-body { padding: 30px 25px; }
        .form-label { color: rgba(255, 255, 255, 0.7); font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        .input-group-text { border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(255, 255, 255, 0.05); color: rgba(255, 255, 255, 0.6); }
        .form-control { background: rgba(255, 255, 255, 0.05) !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; color: #fff !important; border-radius: 0 6px 6px 0; }
        .form-control:focus { background: rgba(255, 255, 255, 0.08) !important; border-color: rgba(83, 52, 131, 0.8) !important; box-shadow: 0 0 0 3px rgba(83, 52, 131, 0.2) !important; }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.3); }
        .btn-reset { background: linear-gradient(135deg, #533483, #0f3460); border: none; color: #fff; padding: 10px 28px; border-radius: 6px; font-weight: 600; letter-spacing: 0.5px; transition: all 0.3s ease; width: 100%; margin-top: 10px; }
        .btn-reset:hover { background: linear-gradient(135deg, #0f3460, #533483); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(83, 52, 131, 0.4); color: #fff; }
        .auth-footer { padding: 16px 25px; border-top: 1px solid rgba(255, 255, 255, 0.06); text-align: center; }
        .auth-footer span { color: rgba(255, 255, 255, 0.3); font-size: 12px; }
        .back-link { color: rgba(255, 255, 255, 0.5); font-size: 13px; text-decoration: none; }
        .back-link:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div class="auth-wrapper">
            <div class="auth-box">
                <div class="auth-header">
                    <img src="{{ asset('backend/images/logo.jpeg') }}" alt="logo" class="auth-header-img">
                    <h4>Maztech Garage Admin</h4>
                    <p>Buat Password Baru</p>
                </div>

                <div class="auth-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif

                    <form action="{{ route('backend.password.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-email"></i></span>
                                </div>
                                <input type="email" name="email" value="{{ $email }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email" required readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password Baru (min. 8 karakter)" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi Password Baru" required>
                            </div>
                        </div>

                        <button class="btn btn-reset" type="submit">
                            <i class="fa fa-lock m-r-5"></i> Reset Password
                        </button>

                        <div class="text-center mt-3">
                            <a href="{{ route('backend.login') }}" class="back-link">
                                <i class="fa fa-arrow-left m-r-5"></i> Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>

                <div class="auth-footer">
                    <span>&copy; {{ date('Y') }} MaztechGarage &mdash; BSI</span>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>$(".preloader").fadeOut();</script>
</body>
</html>

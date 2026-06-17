<!DOCTYPE html>
<html dir="ltr" data-theme="dark">
<head>
    <script>
        (function() {
            var theme = localStorage.getItem('backend_theme');
            if (theme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_mazteach.jpeg') }}">
    <title>Login - MaztechGarage</title>
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            --card-bg: #1e2a3a;
            --card-border: rgba(255, 255, 255, 0.08);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            --header-bg: #000;
            --text-primary: #fff;
            --text-muted: rgba(255, 255, 255, 0.5);
            --text-label: rgba(255, 255, 255, 0.7);
            --input-bg: rgba(255, 255, 255, 0.05);
            --input-border: rgba(255, 255, 255, 0.1);
            --input-text: #fff;
            --input-placeholder: rgba(255, 255, 255, 0.3);
            --input-focus-border: rgba(83, 52, 131, 0.8);
            --input-focus-shadow: rgba(83, 52, 131, 0.2);
            --footer-border: rgba(255, 255, 255, 0.06);
            --footer-text: rgba(255, 255, 255, 0.3);
            --divider-color: rgba(255, 255, 255, 0.2);
            --divider-line: rgba(255, 255, 255, 0.08);
            --btn-recover-border: rgba(255, 255, 255, 0.15);
            --btn-recover-text: rgba(255, 255, 255, 0.5);
            --btn-recover-hover-border: rgba(255, 255, 255, 0.3);
            --btn-recover-hover-text: rgba(255, 255, 255, 0.8);
            --toggle-bg: rgba(255, 255, 255, 0.1);
            --toggle-border: rgba(255, 255, 255, 0.15);
            --toggle-color: #fff;
            --back-link: rgba(255, 255, 255, 0.5);
            --back-link-hover: #fff;
            --recover-text: rgba(255, 255, 255, 0.6);
        }

        [data-theme="light"] {
            --bg-gradient: linear-gradient(135deg, #f0f2f5 0%, #e2e6ea 50%, #f8f9fa 100%);
            --card-bg: #ffffff;
            --card-border: rgba(0, 0, 0, 0.08);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            --header-bg: #f8f9fa;
            --text-primary: #1e293b;
            --text-muted: #64748b;
            --text-label: #475569;
            --input-bg: #f1f5f9;
            --input-border: #cbd5e1;
            --input-text: #1e293b;
            --input-placeholder: #94a3b8;
            --input-focus-border: rgba(83, 52, 131, 0.6);
            --input-focus-shadow: rgba(83, 52, 131, 0.15);
            --footer-border: rgba(0, 0, 0, 0.06);
            --footer-text: #94a3b8;
            --divider-color: rgba(0, 0, 0, 0.3);
            --divider-line: rgba(0, 0, 0, 0.1);
            --btn-recover-border: rgba(0, 0, 0, 0.15);
            --btn-recover-text: rgba(0, 0, 0, 0.4);
            --btn-recover-hover-border: rgba(0, 0, 0, 0.3);
            --btn-recover-hover-text: rgba(0, 0, 0, 0.7);
            --toggle-bg: rgba(0, 0, 0, 0.08);
            --toggle-border: rgba(0, 0, 0, 0.12);
            --toggle-color: #1e293b;
            --back-link: rgba(0, 0, 0, 0.4);
            --back-link-hover: #1e293b;
            --recover-text: rgba(0, 0, 0, 0.5);
        }

        body {
            background: #1a1a2e;
            background: var(--bg-gradient);
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-gradient);
            position: relative;
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
        }

        .auth-header {
            background: var(--header-bg);
            padding: 24px 20px 16px;
            text-align: center;
        }

        .auth-header-img {
            width: 160px;
            height: 160px;
            object-fit: contain;
            object-position: center;
            display: block;
            margin: 0 auto;
        }

        .auth-header h4 {
            color: var(--text-primary);
            margin: 10px 0 4px 0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 12px;
            margin: 0;
            letter-spacing: 1px;
        }

        .auth-body {
            padding: 30px 25px;
        }

        .form-label {
            color: var(--text-label);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .input-group-text {
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--text-label);
        }

        .form-control {
            background: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--input-text) !important;
            border-radius: 0 6px 6px 0;
        }

        .form-control:focus {
            background: var(--input-bg) !important;
            border-color: var(--input-focus-border) !important;
            box-shadow: 0 0 0 3px var(--input-focus-shadow) !important;
        }

        .form-control::placeholder {
            color: var(--input-placeholder);
        }

        .btn-login {
            background: linear-gradient(135deg, #533483, #0f3460);
            border: none;
            color: #fff;
            padding: 10px 28px;
            border-radius: 6px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0f3460, #533483);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(83, 52, 131, 0.4);
            color: #fff;
        }

        .btn-recover {
            background: transparent;
            border: 1px solid var(--btn-recover-border);
            color: var(--btn-recover-text);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-recover:hover {
            border-color: var(--btn-recover-hover-border);
            color: var(--btn-recover-hover-text);
        }

        .auth-footer {
            padding: 16px 25px;
            border-top: 1px solid var(--footer-border);
            text-align: center;
        }

        .auth-footer span {
            color: var(--footer-text);
            font-size: 12px;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: var(--divider-color);
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--divider-line);
        }

        .divider span {
            padding: 0 12px;
        }

        #recoverform {
            display: none;
        }

        .back-to-login {
            color: var(--back-link);
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-to-login:hover {
            color: var(--back-link-hover);
        }

        .recover-text {
            color: var(--recover-text);
            font-size: 13px;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--toggle-bg);
            border: 1px solid var(--toggle-border);
            color: var(--toggle-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(6px);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            background: var(--toggle-bg);
        }

        .theme-toggle svg {
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover svg {
            transform: rotate(15deg);
        }

        .theme-toggle .icon-sun { display: block; }
        .theme-toggle .icon-moon { display: none; }
        [data-theme="light"] .theme-toggle .icon-sun { display: none; }
        [data-theme="light"] .theme-toggle .icon-moon { display: block; }
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

            <!-- Theme Toggle Button -->
            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Ganti tema">
                <svg class="icon-sun" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5"/>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
                <svg class="icon-moon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>

            <div class="auth-box">

                <!-- Header -->
                <div class="auth-header">
                    <img src="{{ asset('backend/images/logo.jpeg') }}" alt="logo" class="auth-header-img">
                    <h4>Maztech Garage Admin</h4>
                    <p>Masuk ke panel administrasi</p>
                </div>

                <!-- Login Form -->
                <div id="loginform">
                    <div class="auth-body">

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>{{ session('error') }}</strong>
                            </div>
                        @endif

                        <form class="form-horizontal" action="{{ route('backend.login') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Masukkan Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-login" type="submit">
                                <i class="fa fa-sign-in m-r-5"></i> Masuk
                            </button>

                            <div class="divider"><span>atau</span></div>

                            <div class="text-center">
                                <button class="btn btn-recover" id="to-recover" type="button">
                                    <i class="fa fa-lock m-r-5"></i> Lupa Password?
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recover Form -->
                <div id="recoverform">
                    <div class="auth-body">
                        <p class="text-center recover-text">
                            Masukkan email kamu untuk mendapatkan tautan reset password.
                        </p>
                        <form class="form-horizontal" action="{{ route('backend.password.email') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-email"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                                </div>
                            </div>

                            <button class="btn btn-login" type="submit">
                                <i class="fa fa-paper-plane m-r-5"></i> Kirim Tautan Reset
                            </button>

                            <div class="text-center mt-3">
                                <a class="back-to-login" id="to-login">
                                    <i class="fa fa-arrow-left m-r-5"></i> Kembali ke Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="auth-footer">
                    <span>&copy; {{ date('Y') }} MaztechGarage &mdash; BSI</span>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('backend/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();

        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        $('#to-login').on("click", function() {
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });

        // Theme Toggle
        $('#themeToggle').on('click', function() {
            var html = document.documentElement;
            var current = html.getAttribute('data-theme');
            var next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('backend_theme', next);
        });
    </script>
</body>

</html>

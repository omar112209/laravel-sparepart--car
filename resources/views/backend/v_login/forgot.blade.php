<!DOCTYPE html>
<html dir="ltr" data-theme="light">
<head>
    <script>
        (function() {
            var theme = localStorage.getItem('backend_theme');
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_mazteach.jpeg') }}">
    <title>Lupa Password - MaztechGarage</title>
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #FDF5F5 0%, #FFE8E8 50%, #FFF0F0 100%);
            --card-bg: #ffffff;
            --card-border: rgba(0, 0, 0, 0.08);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            --header-bg: #f8f9fa;
            --text-primary: #2D1B1B;
            --text-muted: #9A7A7A;
            --text-label: #5C3A3A;
            --input-bg: #FFF5F5;
            --input-border: #E8D0D0;
            --input-text: #2D1B1B;
            --input-placeholder: #C0A0A0;
            --input-focus-border: rgba(200, 16, 46, 0.6);
            --input-focus-shadow: rgba(200, 16, 46, 0.15);
            --footer-border: rgba(0, 0, 0, 0.06);
            --footer-text: #B09090;
            --toggle-bg: rgba(0, 0, 0, 0.06);
            --toggle-border: rgba(0, 0, 0, 0.1);
            --toggle-color: #2D1B1B;
            --back-link: rgba(0, 0, 0, 0.4);
            --back-link-hover: #2D1B1B;
            --desc-text: rgba(0, 0, 0, 0.5);
        }

        [data-theme="dark"] {
            --bg-gradient: linear-gradient(135deg, #100808 0%, #1C0E0E 50%, #2A1515 100%);
            --card-bg: #1C0E0E;
            --card-border: rgba(255, 255, 255, 0.08);
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            --header-bg: #000;
            --text-primary: #fff;
            --text-muted: rgba(255, 255, 255, 0.5);
            --text-label: rgba(255, 255, 255, 0.7);
            --input-bg: rgba(255, 255, 255, 0.06);
            --input-border: rgba(255, 255, 255, 0.12);
            --input-text: #fff;
            --input-placeholder: rgba(255, 255, 255, 0.3);
            --input-focus-border: rgba(200, 16, 46, 0.8);
            --input-focus-shadow: rgba(200, 16, 46, 0.2);
            --footer-border: rgba(255, 255, 255, 0.06);
            --footer-text: rgba(255, 255, 255, 0.3);
            --toggle-bg: rgba(255, 255, 255, 0.1);
            --toggle-border: rgba(255, 255, 255, 0.15);
            --toggle-color: #fff;
            --back-link: rgba(255, 255, 255, 0.5);
            --back-link-hover: #fff;
            --desc-text: rgba(255, 255, 255, 0.6);
        }

        body { background: var(--bg-gradient); }
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--bg-gradient); position: relative; }
        .auth-box { width: 100%; max-width: 420px; border-radius: 12px; overflow: hidden; box-shadow: var(--card-shadow); background: var(--card-bg) !important; border: 1px solid var(--card-border) !important; }
        .auth-header { background: var(--header-bg); padding: 24px 20px 16px; text-align: center; }
        .auth-header-img { width: 160px; height: 160px; object-fit: contain; object-position: center; display: block; margin: 0 auto; }
        .auth-header h4 { color: var(--text-primary); margin: 10px 0 4px 0; font-size: 18px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .auth-header p { color: var(--text-muted); font-size: 12px; margin: 0; letter-spacing: 1px; }
        .auth-body { padding: 30px 25px; }
        .form-label { color: var(--text-label); font-size: 13px; font-weight: 500; margin-bottom: 6px; }
        .input-group-text { border: 1px solid var(--input-border); background: var(--input-bg); color: var(--text-label); }
        .form-control { background: var(--input-bg) !important; border: 1px solid var(--input-border) !important; color: var(--input-text) !important; border-radius: 0 6px 6px 0; }
        .form-control:focus { background: var(--input-bg) !important; border-color: var(--input-focus-border) !important; box-shadow: 0 0 0 3px var(--input-focus-shadow) !important; }
        .form-control::placeholder { color: var(--input-placeholder); }
        .btn-send { background: linear-gradient(135deg, #C8102E, #9A0C23); border: none; color: #fff; padding: 10px 28px; border-radius: 6px; font-weight: 600; letter-spacing: 0.5px; transition: all 0.3s ease; width: 100%; margin-top: 10px; }
        .btn-send:hover { background: linear-gradient(135deg, #9A0C23, #C8102E); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(200, 16, 46, 0.4); color: #fff; }
        .auth-footer { padding: 16px 25px; border-top: 1px solid var(--footer-border); text-align: center; }
        .auth-footer span { color: var(--footer-text); font-size: 12px; }
        .back-link { color: var(--back-link); font-size: 13px; text-decoration: none; }
        .back-link:hover { color: var(--back-link-hover); }
        .desc-text { color: var(--desc-text); font-size: 13px; margin-bottom: 20px; }

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
        .theme-toggle:hover { transform: scale(1.1); background: var(--toggle-bg); }
        .theme-toggle svg { transition: transform 0.3s ease; }
        .theme-toggle:hover svg { transform: rotate(15deg); }
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
                <div class="auth-header">
                    <img src="{{ asset('backend/images/logo.jpeg') }}" alt="logo" class="auth-header-img">
                    <h4>Maztech Garage Admin</h4>
                    <p>Reset Password</p>
                </div>

                <div class="auth-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif

                    <p class="desc-text">
                        Masukkan email admin Anda untuk mendapatkan tautan reset password.
                    </p>

                    <form action="{{ route('backend.password.email') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ti-email"></i></span>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan Email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-send" type="submit">
                            <i class="fa fa-paper-plane m-r-5"></i> Kirim Tautan Reset
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
    <script>
        $(".preloader").fadeOut();

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

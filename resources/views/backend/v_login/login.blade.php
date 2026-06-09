<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_mazteach.jpeg') }}">
    <title>Login - MaztechGarage</title>
    <!-- Custom CSS -->
    <link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: #1a1a2e;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            background: #1e2a3a !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .auth-header {
            background: #000;
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
            color: #fff;
            margin: 10px 0 4px 0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .auth-header p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            margin: 0;
            letter-spacing: 1px;
        }

        .auth-body {
            padding: 30px 25px;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .input-group-text {
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-radius: 0 6px 6px 0;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(83, 52, 131, 0.8) !important;
            box-shadow: 0 0 0 3px rgba(83, 52, 131, 0.2) !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
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
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.5);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-recover:hover {
            border-color: rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.8);
        }

        .auth-footer {
            padding: 16px 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            text-align: center;
        }

        .auth-footer span {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: rgba(255, 255, 255, 0.2);
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
        }

        .divider span {
            padding: 0 12px;
        }

        #recoverform {
            display: none;
        }

        .back-to-login {
            color: rgba(255, 255, 255, 0.5);
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .back-to-login:hover {
            color: #fff;
        }
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
                        <p class="text-center" style="color: rgba(255,255,255,0.6); font-size: 13px;">
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
    </script>
</body>

</html>

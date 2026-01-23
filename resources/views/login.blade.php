<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('Login', 'Login - Akademi Cendekia')</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        rel="stylesheet"
    />
    <style>
        body {
            margin: 0;
            background: linear-gradient(to bottom, #03132a, #1877ff);
            min-height: 100vh; /* Menggunakan min-height agar bisa discroll di HP */
            display: flex;
            flex-direction: column;
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        .navbar {
            width: 100%;
            z-index: 100;
        }

        .navbar a {
            border: 2px solid #2F6FCA !important; 
            border-radius: 8px !important; 
            color: white !important;
            padding: 5px 20px !important;
            transition: all 0.3s ease; 
            text-decoration: none;
            white-space: nowrap; /* Mencegah teks turun baris */
        }

        .navbar a:hover {
            background-color: #2F6FCA;
            transition: all 0.3s ease; 
        }

        /* Container utama untuk menengahkan konten */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .welcome {
            color: white;
            /* Margin dihapus, diganti dengan spacing bootstrap */
        }

        .blur-form {
            background-color: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(8px);
            width: 100%;
            max-width: 400px; /* Agar tidak terlalu lebar di layar besar */
            border-radius: 20px;
            color: white;
            padding: 30px 20px; /* Padding disesuaikan */
            margin: 0 auto; /* Tengah secara horizontal */
        }

        .masuk-akun {
            font-size: 26px;
            font-weight: 500;
            margin-bottom: 30px;
        }

        /* --- PERBAIKAN INPUT --- */
        .input-group-custom {
            position: relative;
            width: 100%; /* Full width mengikuti parent */
            margin-bottom: 25px;
        }

        .custom-input input.form-control {
            background: transparent !important;
            border: none !important;
            border-radius: 0;
            border-bottom: 1.5px solid white !important;
            padding: 10px 45px !important; 
            color: white !important;
            width: 100% !important;
            height: 45px;
        }

        .custom-input input::placeholder {
            color: rgba(204, 204, 204, 0.7) !important;
        }

        .custom-input input.form-control:focus {
            box-shadow: none !important;
            border-color: #03132a !important;
        }

        .input-icon-left {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: white;
            z-index: 10;
            pointer-events: none;
        }

        .password-toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            font-size: 18px;
            color: white;
        }

        .login-button {
            background: #FFFF !important;
            border-radius: 6px;
            border: none !important;
            width: 120px;
            height: 35px;
            display: block;
            margin: 40px auto 0 auto;
            font-weight: 500;
            color: #2F6FCA;
        }

        .login-button:hover{
            background: #03132a !important;
            color: #fff;
        }

        .daftar{
            color: black;
            font-weight: 700;
            text-decoration: none;
        }

        .daftar:hover{
            color: #FFFF;
        }

        /* Responsiveness Tweaks */
        @media (max-width: 991px) {
            .welcome {
                text-align: center;
                margin-bottom: 40px;
            }
            .welcome p:first-child {
                font-size: 28px !important;
            }
            .welcome p:last-child {
                font-size: 20px !important;
            }
            .blur-form {
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container border-bottom border-2 pb-3" style="border-color: #2F6FCA !important;">
            <a href="{{route('Landing_Page')}}">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="logo-img" style="width: 150px;">
            </a>
            <div class="ms-auto">
                <a class="nav-link" href="{{route('Landing_Page')}}">Beranda</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="welcome">
                        <p style="font-weight: 500; font-size: 32px;" class="mb-2">Selamat Datang Kembali!</p>
                        <p style="font-size: 26px; font-weight: 400;">Yuk lanjutkan perjalanan belajarmu di <br> Akademi Cendekia.</p>
                    </div>
                </div>
                
                <div class="col-12 col-lg-5 offset-lg-1">
                    <div class="blur-form shadow-sm">
                        <p class="masuk-akun text-center">Masuk Akun</p>
                        
                        <form action="{{route('login')}}" method="POST" class="custom-input">
                            @csrf
                            <div class="input-group-custom">
                                <i class="bi bi-person-circle input-icon-left"></i>
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>

                            <div class="input-group-custom">
                                <i class="bi bi-lock-fill input-icon-left"></i>
                                <input id="passwordField" name="password" type="password" class="form-control" placeholder="Password" required>
                                <i id="TogglePassword" class="bi bi-eye password-toggle-icon"></i>
                            </div>

                            @if ($errors->any())
                                <div class="text-danger text-center mb-2" style="font-size: 0.8rem;">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <button type="submit" class="login-button">Masuk</button>
                        </form>

                        <p class="mt-4 text-center">Belum punya akun? <a href="{{route('register')}}" class="daftar">Daftar</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#TogglePassword');
        const password = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
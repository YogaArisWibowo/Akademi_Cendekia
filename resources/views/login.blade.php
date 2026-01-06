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
                height: 100vh;
                overflow: hidden;
            }

            .navbar a {
                border: 2px solid #2F6FCA !important; 
                border-radius: 8px !important; 
                color: white !important;
                padding: 5px 20px !important;
                transition: all 0.3s ease; 
                text-decoration: none;
            }

            .navbar a:hover {
                background-color: #2F6FCA;
                transition: all 0.3s ease; 
            }

            .welcome {
                color: white;
                margin-left: 120px;
                margin-top: 40px;
            }

            .blur-form {
                background-color: rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(8px);
                width: 400px;
                height: 400px;
                border-radius: 20px;
                color: white;
                margin-left: 220px;
                margin-top: 40px;
                padding: 20px;
            }

            .masuk-akun {
                font-size: 26px;
                font-weight: 500;
                margin-bottom: 30px;
            }

            /* --- PERBAIKAN INPUT AGAR TEKS TIDAK MENABRAK IKON --- */
            .input-group-custom {
                position: relative;
                width: 90%;
                margin: 0 auto 25px auto;
            }

            .custom-input input.form-control {
                background: transparent !important;
                border: none !important;
                border-radius: 0;
                border-bottom: 1.5px solid white !important;
                /* PENTING: Padding kiri 45px agar teks mulai setelah ikon */
                /* Padding kanan 45px agar teks tidak menabrak ikon mata */
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

            /* Posisi Ikon Kiri (Profil & Gembok) */
            .input-icon-left {
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 20px;
                color: white;
                z-index: 10;
                pointer-events: none; /* Agar klik tembus ke input */
            }

            /* Posisi Ikon Kanan (Mata) */
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
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container-fluid border-bottom border-2 pb-3" style="border-color: #2F6FCA !important;">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="logo-img ms-4" style="width: 170px;">
                <div class="ms-auto">
                    <a class="nav-link" href="{{route('Landing_Page')}}">Beranda</a>
                </div>
            </div>
        </nav>

        <div class="d-flex justify-content-start align-items-center">
            <div class="welcome">
                <p style="font-weight: 500; font-size: 32px;">Selamat Datang Kembali!</p>
                <p style="font-size: 26px; font-weight: 400;">Yuk lanjutkan perjalanan belajarmu di <br> Akademi Cendekia.</p>
            </div>
            
            <div class="blur-form">
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
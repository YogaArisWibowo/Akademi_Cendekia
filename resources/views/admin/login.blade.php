<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('Login')</title>
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
            }
            .navbar a {
                /* Tambahkan 'solid' agar garisnya terlihat */
                border: 2px solid #2F6FCA !important; 
                border-radius: 8px !important; /* Sedikit lebih tumpul agar modern */
                color: white !important;
                padding: 5px 20px !important;
                transition: all 0.3s ease; /* Transisi halus saat hover */
                text-decoration: none;
            }

            .navbar a:hover {
                background-color: rgba(255, 255, 255, 0.1);
                border-color: white !important; /* Warna berubah saat hover */
            }

            .welcome{
                color: white;
                margin-left: 120px;
                margin-top: 150px;
            }
            
            .blur-form {
                background-color:  rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(8px);
                width: 400px;
                height: 350px;
                border-radius: 20px;
                color: white;
                border: 1px;
                margin-left: 220px;
                margin-top: 150px;
            }
            .masuk-akun{
                font-size: 26px;
                font-weight: 500;
            }
            .custom-input input.form-control {
                background: transparent !important;
                border: none !important;
                border-radius: 0;
                border-width: 3px;
                border-bottom: 1px solid white !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                width: 90% !important;
                color: white !important;
                margin-left: 20px;
                margin-top: 40px;
            }
            .custom-input input::placeholder{
                color: #cccc !important;
                padding-left: 40px;
            }
            .custom-input input.form-control:focus{
                background: transparent !important;
                box-shadow: none !important;
                border-color: #03132a !important;
            }
            .login-button{
                background: #FFFF !important;
                border-radius: 6px;
                border: none !important;
                width:  100px;
                height: 30px;
                margin-left: 150px;
                margin-top: 40px;
                font-weight: 500;
                color: #2F6FCA;
            }
            .login-button:hover{
                background: rgba(255, 255, 255, 0.3) !important;
                color: white !important;
            }
            .password-container{
                position: relative;
            }
            .password-toggle-icon{
                position: absolute;
                right: 30px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                z-index: 10;
            }
            .password-input{
                padding-right: 30px;
            }
            .lock{
                position: absolute;
                left: 10px;
                top: 30px;
                transform: translateY(-90%);
                z-index: 10;
                left: 30px;
                font-size: 22px;
            }
            .user{
                position: absolute;
                left: 10px;
                top: 100px;
                transform: translateY(-30%);
                z-index: 10;
                left: 30px;
                font-size: 22px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container-fluid border-bottom border-2 pb-3"
            style="border-color: #2F6FCA !important;">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="logo-img ms-4 "
                style="width: 170px;">
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="collapse navbar-collapse" 
                    id="navbarSupportedContent"
                >
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a
                                class="nav-link active text-white me-4 px-3 py-0 pb-1 "
                                aria-current="page"
                                href="{{route('Landing_Page')}}"
                                >Beranda</a
                            >
                        </li>
                </div>
            </div>
        </nav>

        <div class="d-flex justify-content-start align-items-center" style="height: 300px;">
            <div class="welcome">
                <p style="font-weight: 500; font-size: 32px;;"> Selamat Datang Kembali!</p><br>
                <p style="font-size: 26px; font-weight: 400;">Yuk lanjutkan perjalanan belajarmu di <br> Akademi Cendekia.</p>
            </div>
            <div class="blur-form">
                <p class="pt-2 masuk-akun text-center">Masuk Akun</p>
                <div class="custom-input">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Username" required>
                        <i class="bi bi-person-circle user"></i>
                    </div>

                    <div class="mb-3 password-container">
                        <input name="password" type="password" class="form-control password-input" placeholder="Password" required >
                            <i class="bi bi-lock-fill lock"></i>
                            <i id="TogglePassword" class="bi bi-eye password-toggle-icon"></i>
                    </div>
                </div>

                <button class="login-button text-center">
                    Masuk
                </button>
                <p class="mt-4 text-center">Belum punya akun? <a href="{{route('register')}}" class="text-black fw-bold text-decoration-none">Daftar</a></p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

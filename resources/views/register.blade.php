<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>@yield('Register')</title>
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
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                font-family: 'Segoe UI', sans-serif;
                overflow-x: hidden;
            }

            .main-content {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
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
                background-color: rgba(255, 255, 255, 0.1);
                border-color: white !important;
            }

            .blur-form {
                background: rgba(255, 255, 255, 0.15) !important;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                width: 100%;
                max-width: 800px;
                padding: 40px;
                border-radius: 40px;
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
                text-align: center;
                transition: all 0.4s ease;
            }

            .role-switcher {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50px;
                display: inline-flex;
                padding: 5px;
                margin-bottom: 30px;
                position: relative; /* Tambahan untuk posisi animasi */
            }

            /* TAMBAHAN: Elemen Animasi Switch */
            .slide-bg {
                position: absolute;
                top: 5px;
                left: 5px;
                height: calc(100% - 10px);
                background: white;
                border-radius: 50px;
                transition: all 0.4s ease-in-out;
                z-index: 0;
            }

            .role-btn {
                padding: 8px 35px;
                border-radius: 50px;
                border: none;
                background: transparent;
                color: white;
                font-weight: 600;
                font-size: 14px;
                transition: 0.3s;
                position: relative; /* Agar di atas slide-bg */
                z-index: 1;
            }
            .role-btn.active {
                background: transparent; /* Ubah ke transparan karena sudah ada slide-bg */
                color: #2F6FCA;
            }

            /* Input & Icon Styling */
            .custom-input .form-control {
                background: transparent !important;
                border: none !important;
                border-bottom: 1.5px solid rgba(255, 255, 255, 0.8) !important;
                border-radius: 0 !important;
                color: white !important;
                padding: 10px 0 !important;
                margin-bottom: 25px;
                font-size: 16px;
            }
            .custom-input .form-control::placeholder {
                color: rgba(255, 255, 255, 0.6) !important;
            }
            .custom-input .form-control:focus {
                box-shadow: none !important;
                border-bottom-color: #fff !important;
            }

            /* Password Icon Wrapper */
            .password-wrapper {
                position: relative;
            }
            .password-wrapper i {
                position: absolute;
                right: 0;
                top: 10px;
                cursor: pointer;
                color: rgba(255, 255, 255, 0.7);
                font-size: 1.2rem;
                transition: 0.2s;
            }
            .password-wrapper i:hover {
                color: #fff;
            }

            .btn-daftar {
                background: white !important;
                color: #2F6FCA !important;
                border-radius: 10px;
                padding: 10px 50px;
                font-weight: 700;
                border: none;
                transition: 0.3s;
                margin-top: 20px;
            }
            .btn-daftar:hover {
                background: rgba(255, 255, 255, 0.9) !important;
                transform: translateY(-2px);
            }

            .login-link {
                text-decoration: none;
                color: white;
                font-weight: 600;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container-fluid border-bottom border-2 pb-3" style="border-color: #2F6FCA !important;">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="logo-img ms-4" style="width: 170px;">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active text-white me-4 px-3 py-0 pb-1 rounded" href="{{route('Landing_Page')}}">Beranda</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="main-content">
            <div class="blur-form" id="formContainer">
                <h3 class="mb-4 fw-bold">DAFTAR AKUN</h3>
                
                <div class="role-switcher" id="roleContainer">
                    <div class="slide-bg" id="slide-bg"></div> <button type="button" class="role-btn active" onclick="setRole(this, 'siswa')">SISWA</button>
                    <button type="button" class="role-btn" onclick="setRole(this, 'guru')">GURU</button>
                    <button type="button" class="role-btn" onclick="setRole(this, 'admin')">ADMIN</button>
                </div>

                <form action="/register" method="POST">
                    <input type="hidden" name="role" id="user_role" value="siswa">

                    <div class="row custom-input text-start" id="formRow">
                        <div class="col-md-6 px-4 mx-auto" id="leftCol">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                            
                            <div id="student_specific_fields">
                                <input type="text" name="jenjang" class="form-control" placeholder="Jenjang">
                                <input type="text" name="kelas" class="form-control" placeholder="Kelas">
                            </div>

                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                <i class="bi bi-eye" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')"></i>
                            </div>

                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi password" required>
                                <i class="bi bi-eye" id="toggleConfirmPassword" onclick="togglePasswordVisibility('password_confirmation', 'toggleConfirmPassword')"></i>
                            </div>
                        </div>

                        <div class="col-md-6 px-4" id="rightCol">
                            <input type="text" name="asal_sekolah" class="form-control" placeholder="Asal Sekolah" required>
                            <input type="text" name="no_hp" class="form-control" placeholder="No. Handphone" required>
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
                            
                            <div id="parent_field">
                                <input type="text" name="nama_orang_tua" class="form-control" placeholder="Nama Orang Tua">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-daftar">Daftar</button>
                    <p class="mt-4">Sudah punya akun? <a href="{{route('Login')}}" class="text-black fw-bold text-decoration-none">Masuk</a></p>
                </form>
            </div>
        </div>

        <script>
            function togglePasswordVisibility(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace("bi-eye", "bi-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.replace("bi-eye-slash", "bi-eye");
                }
            }

            function resetPasswordFields() {
                const passInputs = ['password', 'password_confirmation'];
                const passIcons = ['togglePassword', 'toggleConfirmPassword'];

                passInputs.forEach((id, index) => {
                    const input = document.getElementById(id);
                    const icon = document.getElementById(passIcons[index]);
                    
                    if (input) input.type = "password";
                    if (icon) {
                        icon.classList.remove("bi-eye-slash");
                        icon.classList.add("bi-eye");
                    }
                });
            }

            function setRole(btn, roleValue) {
                resetPasswordFields(); // Fix bug password

                // Logic Animasi Switch
                const slideBg = document.getElementById('slide-bg');
                slideBg.style.width = btn.offsetWidth + 'px';
                slideBg.style.left = btn.offsetLeft + 'px';

                const buttons = document.querySelectorAll('.role-btn');
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                document.getElementById('user_role').value = roleValue;

                const studentFields = document.getElementById('student_specific_fields');
                const parentField = document.getElementById('parent_field');
                const rightCol = document.getElementById('rightCol');
                const leftCol = document.getElementById('leftCol');
                const formContainer = document.getElementById('formContainer');

                if (roleValue === 'siswa') {
                    rightCol.style.display = 'block';
                    leftCol.className = "col-md-6 px-4";
                    studentFields.style.display = 'block';
                    parentField.style.display = 'block';
                    formContainer.style.maxWidth = "800px";
                } 
                else if (roleValue === 'guru') {
                    rightCol.style.display = 'block';
                    leftCol.className = "col-md-6 px-4";
                    studentFields.style.display = 'none';
                    parentField.style.display = 'none';
                    formContainer.style.maxWidth = "800px";
                } 
                else if (roleValue === 'admin') {
                    rightCol.style.display = 'none';
                    studentFields.style.display = 'none';
                    leftCol.className = "col-md-8 px-4 mx-auto";
                    formContainer.style.maxWidth = "450px";
                }
            }

            // Inisialisasi posisi awal slide-bg
            window.onload = function() {
                const activeBtn = document.querySelector('.role-btn.active');
                const slideBg = document.getElementById('slide-bg');
                slideBg.style.width = activeBtn.offsetWidth + 'px';
                slideBg.style.left = activeBtn.offsetLeft + 'px';
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
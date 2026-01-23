<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('Register', 'Daftar Akun')</title>
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

        .navbar {
            z-index: 10;
        }

        .navbar a {
            border: 2px solid #2F6FCA !important; 
            border-radius: 8px !important; 
            color: white !important;
            padding: 5px 20px !important;
            transition: all 0.3s ease; 
            text-decoration: none;
            white-space: nowrap;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: white !important;
        }

        .blur-form {
            background: rgba(255, 255, 255, 0.15) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            width: 100%; /* Default full width */
            max-width: 800px; /* Batas maksimal desktop */
            padding: 40px;
            border-radius: 40px;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            text-align: center;
            transition: max-width 0.4s ease, padding 0.3s ease;
            position: relative;
        }

        .role-switcher {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            display: inline-flex;
            padding: 5px;
            margin-bottom: 30px;
            position: relative;
            /* Agar responsif di layar sangat kecil */
            max-width: 100%;
            overflow: hidden; 
        }

        .slide-bg {
            position: absolute;
            top: 5px;
            left: 5px;
            height: calc(100% - 10px);
            background: white;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
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
            position: relative;
            z-index: 1;
            white-space: nowrap;
        }
        .role-btn.active {
            color: #2F6FCA;
        }

        .custom-input .form-control {
            background: transparent !important;
            border: none !important;
            border-bottom: 1.5px solid rgba(255, 255, 255, 0.8) !important;
            border-radius: 0 !important;
            color: white !important;
            padding: 10px 0 !important;
            margin-bottom: 25px;
            font-size: 16px;
            width: 100%;
        }

        /* Styling Select */
        .custom-input select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
        .custom-input select option {
            background-color: #1877ff;
            color: white;
        }

        .custom-input .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        .custom-input .form-control:focus {
            box-shadow: none !important;
            border-bottom-color: #fff !important;
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }
        .password-wrapper i {
            position: absolute;
            right: 0;
            top: 10px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            transition: 0.2s;
            z-index: 5;
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
            margin-top: 10px;
            width: auto;
        }
        .btn-daftar:hover {
            background: rgba(255, 255, 255, 0.9) !important;
            transform: translateY(-2px);
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 768px) {
            .navbar .logo-img {
                width: 130px !important;
                margin-left: 0 !important;
            }
            
            .blur-form {
                padding: 25px 20px; /* Padding lebih kecil di HP */
                border-radius: 25px;
            }

            .role-switcher {
                display: flex;
                justify-content: space-between;
                width: 100%;
            }

            .role-btn {
                padding: 8px 0; /* Hapus padding samping agar muat */
                flex: 1; /* Tombol membagi rata lebar container */
                font-size: 13px;
            }

            /* Kolom form menjadi 1 baris */
            #leftCol, #rightCol {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .btn-daftar {
                width: 100%; /* Tombol daftar full width di HP */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container border-bottom border-2 pb-3" style="border-color: #2F6FCA !important;">
            <a href="{{route('Landing_Page')}}">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="logo-img" style="width: 170px;">
            </a>
            
            <div class="ms-auto">
                <a class="nav-link active text-white px-3 py-1 rounded" href="{{route('Landing_Page')}}">Beranda</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="blur-form" id="formContainer">
            @if(session('info'))
                <div class="alert alert-info border-0 mb-3" style="background: rgba(255,255,255,0.2); color: white;">
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 mb-3" style="background: rgba(255,0,0,0.2); color: white;">
                    <ul class="mb-0 text-start" style="font-size: 0.9rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="mb-4 fw-bold">DAFTAR AKUN</h3>
            
            <div class="role-switcher" id="roleContainer">
                <div class="slide-bg" id="slide-bg"></div> 
                <button type="button" class="role-btn active" onclick="setRole(this, 'siswa')">SISWA</button>
                <button type="button" class="role-btn" onclick="setRole(this, 'guru')">GURU</button>
                <button type="button" class="role-btn" onclick="setRole(this, 'admin')">ADMIN</button>
            </div>

            <form id="MainRegisterForm" action="{{ route('Register.post') }}" method="POST">
                @csrf 
                <input type="hidden" name="role" id="user_role" value="siswa">

                <div class="row custom-input text-start" id="formRow">
                    <div class="col-12 col-md-6 px-md-4" id="leftCol">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required>
                        
                        <div id="student_specific_fields">
                            <input type="text" name="jenjang" class="form-control" placeholder="Jenjang">
                        </div>

                        <div id="guru_specific_fields" style="display: none;">
                            <select name="mapel" class="form-control">
                                <option value="" disabled selected>Pilih Mapel</option>
                                @foreach($data_mapel as $m)
                                    <option value="{{ $m->nama_mapel }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <i class="bi bi-eye" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')"></i>
                        </div>

                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi password" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 px-md-4" id="rightCol">
                        
                        <div id="guru_extra_fields" style="display: none;">
                            <input type="text" name="pendidikan_terakhir" class="form-control" placeholder="Pendidikan Terakhir">
                            <input type="text" name="rekening" class="form-control" placeholder="No Rekening">
                            <input type="text" name="no_e_wallet" class="form-control" placeholder="No E-Wallet">
                            <input type="text" name="jenis_e_wallet" class="form-control" placeholder="Jenis E-Wallet">
                        </div>

                        <div id="parent_field">
                            <input type="text" name="kelas" class="form-control" placeholder="Kelas">
                            <input type="text" name="asal_sekolah" class="form-control" placeholder="Asal Sekolah">
                            <input type="text" name="nama_orang_tua" class="form-control" placeholder="Nama Orang Tua">
                        </div>
                        <input type="text" name="no_hp" class="form-control" placeholder="No. Handphone">
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-daftar">Daftar</button>
                    <p class="mt-4 mb-0">Sudah punya akun? <a href="{{route('login')}}" class="text-white fw-bold text-decoration-underline">Masuk</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi Toggle Password
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

        // Reset field password saat ganti role
        function resetPasswordFields() {
            const passInputs = ['password', 'password_confirmation'];
            passInputs.forEach((id) => {
                const input = document.getElementById(id);
                if (input) input.type = "password";
            });
            const icon = document.getElementById('togglePassword');
            if (icon) {
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }

        // Fungsi Update Posisi Background Tombol Role
        function updateSlidePosition() {
            const activeBtn = document.querySelector('.role-btn.active');
            const slideBg = document.getElementById('slide-bg');
            if(activeBtn && slideBg) {
                slideBg.style.width = activeBtn.offsetWidth + 'px';
                slideBg.style.left = activeBtn.offsetLeft + 'px';
            }
        }

        function setRole(btn, roleValue) {
            resetPasswordFields();

            // Update UI Tombol
            const buttons = document.querySelectorAll('.role-btn');
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            updateSlidePosition(); // Panggil fungsi posisi

            // Set Value Input
            document.getElementById('user_role').value = roleValue;

            // Ambil Element
            const studentFields = document.getElementById('student_specific_fields');
            const guruFields = document.getElementById('guru_specific_fields');
            const guruExtra = document.getElementById('guru_extra_fields');
            const parentField = document.getElementById('parent_field');
            const rightCol = document.getElementById('rightCol');
            const leftCol = document.getElementById('leftCol');
            const formContainer = document.getElementById('formContainer');
            const alamatInput = document.getElementsByName('alamat')[0];

            // Logika Tampilan Form
            if (roleValue === 'siswa') {
                formContainer.style.maxWidth = "800px";
                leftCol.className = "col-12 col-md-6 px-md-4"; // Responsive Class
                rightCol.style.display = 'block';
                studentFields.style.display = 'block';
                parentField.style.display = 'block';
                guruFields.style.display = 'none';
                guruExtra.style.display = 'none';
                alamatInput.style.display = 'block';
                alamatInput.required = true;
            } 
            else if (roleValue === 'guru') {
                formContainer.style.maxWidth = "800px";
                leftCol.className = "col-12 col-md-6 px-md-4"; // Responsive Class
                rightCol.style.display = 'block';
                studentFields.style.display = 'none';
                parentField.style.display = 'none';
                guruFields.style.display = 'block';
                guruExtra.style.display = 'block';
                alamatInput.style.display = 'block';
                alamatInput.required = true;
            } 
            else if (roleValue === 'admin') {
                formContainer.style.maxWidth = "450px";
                // Saat admin, kolom kiri jadi full width di containernya
                leftCol.className = "col-12 px-md-4 mx-auto"; 
                rightCol.style.display = 'none';
                studentFields.style.display = 'none';
                guruFields.style.display = 'none';
                alamatInput.style.display = 'none';
                alamatInput.required = false;
            }
        }

        // Event Listener saat load dan resize layar
        window.addEventListener('load', updateSlidePosition);
        window.addEventListener('resize', updateSlidePosition);
        
        // Panggil saat script dimuat untuk inisialisasi awal
        window.onload = function() {
            updateSlidePosition();
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
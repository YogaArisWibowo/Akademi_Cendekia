<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>{{ $title ?? 'Halaman' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <link rel="stylesheet" href="/css/siswa.css">
    <link rel="stylesheet" href="{{ asset('css/tabel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">

    <style>
        /* --- GLOBAL STYLE & RESET --- */
        body {
            overflow-x: hidden; /* Mencegah scroll horizontal */
            background-color: #f8faff;
        }

        /* --- SIDEBAR STYLE (Override/Ensure) --- */
        /* Pastikan class .sidebar ada di file include sidebar Anda, atau sesuaikan selector ini */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            z-index: 1050;
            transition: all 0.3s ease;
            /* Style background dll diasumsikan sudah ada di file include atau css external */
        }

        /* --- MAIN CONTENT & TOPBAR LAYOUT --- */
        /* Desktop: Geser konten ke kanan sebesar lebar sidebar */
        .main-content, .topbar {
            margin-left: 280px; 
            transition: all 0.3s ease;
            width: calc(100% - 280px);
        }

        /* --- TOPBAR STYLING --- */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            height: 70px; /* Sesuaikan tinggi */
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 1040;
        }

        .main-content {
            padding: 90px 20px 20px 20px; /* Padding top > tinggi topbar */
            min-height: 100vh;
        }

        .profile {
            cursor: pointer;
        }
        .dropdown-item:active {
            background-color: #0d6efd;
        }

        /* --- OVERLAY (LAYAR HITAM TRANSPARAN) --- */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1045; /* Di bawah sidebar, di atas konten */
            opacity: 0;
            transition: opacity 0.3s;
        }
        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* --- RESPONSIVE / MOBILE STYLE --- */
        @media (max-width: 992px) { /* Breakpoint Tablet/HP */
            
            /* Sembunyikan Sidebar ke Kiri */
            .sidebar {
                left: -280px;
            }

            /* Saat Sidebar Aktif (Kelas ditambahkan via JS) */
            .sidebar.active {
                left: 0;
            }

            /* Konten & Topbar jadi Full Width */
            .main-content, .topbar {
                margin-left: 0;
                width: 100%;
            }

            /* Judul sedikit mengecil di HP */
            .topbar .title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    {{-- Overlay untuk Mobile --}}
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    {{-- Sidebar --}}
    {{-- Pastikan di dalam file sidebar_admin wrapper utamanya memiliki class "sidebar" --}}
    @include('layouts.sidebar.sidebar_admin')

    {{-- Topbar --}}
    <div class="topbar">
        
        <div class="d-flex align-items-center">
            {{-- TOMBOL HAMBURGER (Hanya muncul di Mobile/Tablet < 992px) --}}
            <button class="btn btn-light d-lg-none me-3 border-0" id="sidebarToggle">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="title fw-bold fs-4 text-dark">{{ $title }}</div>
        </div>

        {{-- AREA PROFILE DENGAN DROPDOWN --}}
        <div class="dropdown">
            
            {{-- Trigger Dropdown --}}
            <div class="profile d-flex align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                {{-- Garis vertikal disembunyikan di HP agar rapi --}}
                <div class="vertical-line me-3 d-none d-md-block" style="border-left: 1px solid #ccc; height: 30px;"></div>

                <div class="profile-icon me-2 d-flex justify-content-center align-items-center text-secondary">
                    <i class="bi bi-person-circle fs-4"></i>
                </div>

                {{-- Nama User (Sembunyikan di HP sangat kecil, tampilkan di Tablet/Desktop) --}}
                <span class="fw-semibold text-dark me-2 d-none d-sm-inline">
                    {{ Auth::user()->admin->username ?? Auth::user()->username ?? 'Admin' }}
                </span>

                <i class="bi bi-caret-down-fill text-dark small"></i>
            </div>

            {{-- Isi Dropdown Menu --}}
            <ul class="dropdown-menu dropdown-menu-end mt-3 shadow border-0">
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>

        </div>
        {{-- END DROPDOWN --}}

    </div>

    {{-- Halaman Konten --}}
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        
        // --- LOGIKA SIDEBAR RESPONSIVE ---
        const $sidebar = $('.sidebar'); // Pastikan selector ini sesuai dengan class di file include
        const $overlay = $('#sidebarOverlay');
        const $toggleBtn = $('#sidebarToggle');

        // 1. Klik Tombol Hamburger
        $toggleBtn.on('click', function(e) {
            e.stopPropagation(); // Cegah event bubbling
            $sidebar.toggleClass('active');
            $overlay.toggleClass('active');
        });

        // 2. Klik Overlay (Menutup Sidebar)
        $overlay.on('click', function() {
            $sidebar.removeClass('active');
            $(this).removeClass('active');
        });

        // --- Logika Status Dropdown (Kode Lama Anda) ---
        $('[id^="status-select-"]').on('change', function() {
            var selectedValue = $(this).val(); 
            var dropdownId = $(this).attr('id'); 
            var itemId = dropdownId.split('-').pop(); 

            // Ubah warna baris
            var tableRow = $(this).closest('tr');
            if (selectedValue === 'non aktif') {
                tableRow.addClass('table-secondary'); 
            } else {
                tableRow.removeClass('table-secondary');
            }
        });
    });
    </script>

</body>
</html>
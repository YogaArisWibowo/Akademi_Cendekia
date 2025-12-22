<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Halaman' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/siswa.css">
    <link rel="stylesheet" href="{{ asset('css/tabel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div id="sidebar-wrapper">
        @include('layouts.sidebar.sidebar_siswa')
    </div>

    {{-- Topbar --}}
    <div class="topbar">
        <button class="hamburger-btn" id="hamburgerBtn">
            <i class="bi bi-list"></i>
        </button>

        <div class="title">{{ $title }}</div>

        <div class="profile d-flex align-items-center">
            <div class="vertical-line me-3 d-none d-md-block"></div>
            <div class="profile-icon me-2 d-flex justify-content-center align-items-center">
                <i class="bi bi-person-fill"></i>
            </div>

            <span class="fw-semibold text-dark me-2 d-none d-md-inline">Guru MTK</span>
            <i class="bi bi-caret-down-fill text-dark"></i>
        </div>
    </div>

    {{-- Halaman Konten --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            // Kita cari class .sidebar-siswa di dalam wrapper, atau langsung sidebar-siswa
            const sidebar = document.querySelector('.sidebar-siswa');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                } else {
                    console.error("Elemen Sidebar atau Overlay tidak ditemukan!");
                }
            }

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>

</html>

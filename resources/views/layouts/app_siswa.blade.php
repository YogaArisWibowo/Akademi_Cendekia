<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

    {{-- Sidebar --}}
    @include('layouts.sidebar.sidebar_siswa')

    {{-- Topbar --}}
    <div class="topbar">
        <div class="title">{{ $title }}</div>

        <div class="profile d-flex align-items-center">

            <!-- Garis vertikal -->
            <div class="vertical-line me-3"></div>

            <!-- Icon profil -->
            <div class="profile-icon me-2 d-flex justify-content-center align-items-center">
                <i class="bi bi-person-fill"></i>
            </div>

            <!-- Nama -->
            <span class="fw-semibold text-dark me-2">Hafidz</span>

            <!-- Icon dropdown -->
            <i class="bi bi-caret-down-fill text-dark"></i>

        </div>

    </div>

    {{-- Halaman Konten --}}
    <main class="main-content">
        @yield('content')
    </main>

</body>
</html>

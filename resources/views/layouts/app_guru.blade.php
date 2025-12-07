<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Guru' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/tabel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/button.css') }}">
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">


    @include('layouts.style')
</head>

<body>
    @include('layouts.sidebar.sidebar_guru')

    {{-- Topbar --}}
    {{-- <div class="topbar">
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

    </div> --}}

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

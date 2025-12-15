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
    @include('layouts.sidebar.sidebar_admin')

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
            <span class="fw-semibold text-dark me-2">Admin</span>

            <!-- Icon dropdown -->
            <i class="bi bi-caret-down-fill text-dark"></i>

        </div>

    </div>

    {{-- Halaman Konten --}}
    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
        // Pastikan DOM sudah dimuat sepenuhnya
    $(document).ready(function() {
        // Gunakan selector yang lebih umum karena Anda mungkin punya banyak baris
        // Menggunakan attribute 'id' yang diawali dengan 'status-select-'
        $('[id^="status-select-"]').on('change', function() {
            var selectedValue = $(this).val(); // Dapatkan nilai yang dipilih ('aktif' atau 'non aktif')
            var dropdownId = $(this).attr('id'); // Dapatkan ID dropdown
            
            // Ekstrak ID unik dari elemen, misalnya '1' dari 'status-select-1'
            var itemId = dropdownId.split('-').pop(); 

            // --- Aksi Front-End Saja (Tanpa Ajax) ---
            
            console.log('Item ID: ' + itemId + ' | Status Baru: ' + selectedValue);
            
            // Contoh aksi front-end: Tampilkan notifikasi
            alert('Status untuk ID ' + itemId + ' telah diubah menjadi: ' + selectedValue + '. Perubahan ini TIDAK tersimpan ke database.');

            // Jika Anda ingin mengubah warna baris (Contoh):
            var tableRow = $(this).closest('tr');
            if (selectedValue === 'non aktif') {
                tableRow.addClass('table-secondary'); // Beri warna abu-abu
            } else {
                tableRow.removeClass('table-secondary'); // Hapus warna
            }

            // --- Jika ingin menyimpan (Perlu AJAX) ---
            /* $.ajax({
                url: '/update-status/' + itemId, // Ganti dengan rute update Laravel Anda
                method: 'POST',
                data: { 
                    status: selectedValue,
                    _token: '{{ csrf_token() }}' // Penting untuk Laravel
                },
                success: function(response) {
                    // Tampilkan pesan sukses dari server
                    console.log('Berhasil disimpan:', response);
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    console.error('Gagal menyimpan:', xhr.responseText);
                }
            });
            */
            // ----------------------------------------
        });
    });
    </script>

</body>
</html>

@extends('layouts.app_admin', ['title' => 'Monitoring Guru']) 
@section('content')

{{-- 1. LOAD JQUERY (WAJIB) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    /* CSS GLOBAL */
    .back { background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px; color: white; font-weight: 500; font-size: large; cursor: pointer; align-items: center; justify-content: center; margin-bottom: 20px; }
    .back i { padding-right: 5px; }
    .profile-info h3 { margin: 0; font-weight: 700; color: #1f2937; }
    
    .badge-number { background-color: #2b6cb0; color: white; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; box-shadow: 0 4px 6px rgba(43, 108, 176, 0.3); }
    .custom-card { background: #ffffff; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease; width: 60%; height: 80px; }
    .card-body-content { display: flex; justify-content: space-between; align-items: center; }
    .name { margin: 0; font-weight: 700; color: #1a202c; }

    /* CSS PAGINATION (Sama seperti Monitoring Guru) */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        padding: 20px 0;
        margin-top: 20px;
    }

    .btn-page {
        border: 1px solid #d1d5db;
        background-color: white;
        color: #374151;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn-page:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }

    .btn-page.active {
        background-color: #3b82f6; /* Warna Biru Utama */
        color: white;
        border-color: #3b82f6;
    }

    .btn-page:disabled {
        background-color: #f9fafb;
        color: #9ca3af;
        cursor: not-allowed;
        border-color: #e5e7eb;
    }

    .img-thumbnail-mini {
    width: 60px;        /* Lebar gambar kecil */
    height: 60px;       /* Tinggi gambar kecil */
    object-fit: cover;  /* Memotong gambar agar pas kotak (tidak gepeng) */
    border-radius: 6px; /* Membuat sudut tumpul */
    border: 1px solid #e2e8f0;
    transition: transform 0.2s;
    }

    /* Efek saat mouse diarahkan ke gambar */
    .img-thumbnail-mini:hover {
        transform: scale(1.1); /* Zoom sedikit */
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Monitoring_Guru') }}">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

<div class="profile-info mb-4">
    <h3>{{ $guru->nama }}</h3>
</div>

<div class="custom-card ">
    <div class="card-body-content">
        <div class="info">
            <h5 class="name">Total Absensi</h5>
        </div>
        <div class="badge-number">{{ $total_absensi }}</div>
    </div>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mapel</th>
                <th>Bukti Kehadiran</th>
                <th>Catatan</th>
            </tr>
        </thead>

        {{-- ID DITAMBAHKAN DI SINI UNTUK TARGET JS --}}
        <tbody id="absensiTableBody">
            @forelse($riwayat_absensi as $index => $absen)
            {{-- CLASS DITAMBAHKAN UNTUK TARGET ROW JS --}}
            <tr class="absensi-row">
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->isoFormat('dddd') }}</td>
                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $absen->waktu }}</td>
                <td>{{ $absen->mapel }}</td>
                <td>
                    {{-- Cek apakah variabel ada datanya --}}
                    @if(!empty($absen->bukti_foto))
                        <a href="{{ asset('bukti_absensi/' . $absen->bukti_foto) }}" target="_blank">
                            <img src="{{ asset('bukti_absensi/' . $absen->bukti_foto) }}" 
                                alt="Bukti" 
                                class="img-thumbnail-mini"
                                {{-- Tambahan: Jika gambar error/tidak ketemu, ganti dengan placeholder --}}
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/60?text=No+Img';">
                        </a>

                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $absen->laporan_kegiatan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Belum ada riwayat absensi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- CONTAINER PAGINATION JS --}}
    <div id="paginationContainer" class="pagination-wrapper">
    </div>
</div>

{{-- SCRIPT PAGINATION --}}
<script>
    $(document).ready(function() {
        // --- KONFIGURASI ---
        const rowsPerPage = 10; // Tentukan mau berapa baris per halaman
        const $rows = $("#absensiTableBody .absensi-row"); // Ambil semua baris
        const $paginationContainer = $("#paginationContainer");
        let currentPage = 1;

        // Jika tidak ada data, sembunyikan pagination
        if ($rows.length === 0) {
            $paginationContainer.hide();
            return;
        }

        // --- FUNGSI TAMPILKAN HALAMAN ---
        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Logic: Sembunyikan semua, lalu munculkan range yang diminta
            $rows.hide().slice(start, end).fadeIn(200); // 200ms animasi
            
            renderButtons();
        }

        // --- FUNGSI RENDER TOMBOL ---
        function renderButtons() {
            const totalRows = $rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            
            $paginationContainer.empty();

            // Jika cuma 1 halaman, sembunyikan pagination
            if (totalPages <= 1) {
                return; 
            }

            // 1. Tombol Sebelumnya
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            $paginationContainer.append(`<button type="button" class="btn-page prev" ${prevDisabled}>Sebelumnya</button>`);

            // 2. Tombol Angka
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                $paginationContainer.append(`<button type="button" class="btn-page num ${activeClass}" data-page="${i}">${i}</button>`);
            }

            // 3. Tombol Selanjutnya
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            $paginationContainer.append(`<button type="button" class="btn-page next" ${nextDisabled}>Selanjutnya</button>`);
        }

        // --- EVENT LISTENER ---
        
        // Klik Angka
        $(document).on("click", ".num", function() {
            showPage($(this).data("page"));
        });

        // Klik Sebelumnya
        $(document).on("click", ".prev", function() {
            if (currentPage > 1) showPage(currentPage - 1);
        });

        // Klik Selanjutnya
        $(document).on("click", ".next", function() {
            const totalPages = Math.ceil($rows.length / rowsPerPage);
            if (currentPage < totalPages) showPage(currentPage + 1);
        });

        // Jalankan saat pertama kali load
        showPage(1);
    });
</script>

@endsection
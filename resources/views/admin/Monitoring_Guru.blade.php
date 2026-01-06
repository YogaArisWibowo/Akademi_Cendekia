@extends('layouts.app_admin', ['title' => 'Monitoring Guru'])
@section('content')

{{-- CSS --}}
<style>
    .content-wrapper { padding: 20px; }
    
    .guru-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .guru-card-link { text-decoration: none; color: inherit; }

    .guru-card {
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        border-radius: 8px;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.263);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid transparent;
        padding: 5px;
    }

    .guru-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .nama { font-weight: 600 !important; color: #343a40; font-size: 18px; }
    .guru-title { font-size: 14px; color: #6c757d; font-weight: 500; }
    .guru-info { margin: 0; font-size: 13px; display: block; text-align: left; color: #718096; }

    /* --- STYLE PAGINATION JAVASCRIPT --- */
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
</style>

<div class="content-wrapper">
    
    {{-- Grid Kartu Guru --}}
    {{-- PENTING: ID="guruGrid" ditambahkan untuk selector JS --}}
    <div class="guru-grid" id="guruGrid">
        
        @forelse($gurus as $guru)
            {{-- PENTING: Class="guru-item" ditambahkan agar JS bisa menghitung item --}}
            <div class="guru-item"> 
                <a href="{{route('admin_detail_monitoring_guru', $guru->id)}}" class="guru-card-link">
                    <div class="guru-card">
                        <span class="nama">{{ $guru->nama }}</span>
                        <div class="guru-info">
                            <span class="guru-title">Guru Mapel: {{ $guru->mapel ?? '-' }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="alert alert-info w-100" style="grid-column: span 2;">
                Belum ada data guru.
            </div>
        @endforelse

    </div>

    {{-- Container Pagination JS --}}
    <div id="paginationGuru" class="pagination-wrapper">
        {{-- Tombol akan digenerate otomatis oleh Script di bawah --}}
    </div>

</div>

{{-- 1. Load jQuery (Wajib ada) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- 2. Script Pagination --}}
<script>
    $(document).ready(function() {
        // --- KONFIGURASI ---
        const rowsPerPage = 10; // Jumlah kartu per halaman
        const $items = $("#guruGrid .guru-item"); // Selector item guru
        const $paginationContainer = $("#paginationGuru");
        let currentPage = 1;

        // Cek jika tidak ada data, sembunyikan pagination
        if ($items.length === 0) {
            $paginationContainer.hide();
            return;
        }

        // --- FUNGSI TAMPILKAN HALAMAN ---
        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            // Sembunyikan semua, lalu munculkan yang sesuai range
            $items.hide().slice(start, end).fadeIn(300);
            
            renderButtons();
            
            // Scroll ke atas grid (opsional)
            // $("html, body").animate({ scrollTop: $(".content-wrapper").offset().top }, "fast");
        }

        // --- FUNGSI RENDER TOMBOL PAGINATION ---
        function renderButtons() {
            const totalRows = $items.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            
            $paginationContainer.empty();

            if (totalPages <= 1) return; // Jika cuma 1 halaman, tidak usah tampil tombol

            // Tombol Sebelumnya
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            $paginationContainer.append(`<button type="button" class="btn-page prev" ${prevDisabled}>Sebelumnya</button>`);

            // Tombol Angka
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                $paginationContainer.append(`<button type="button" class="btn-page num ${activeClass}" data-page="${i}">${i}</button>`);
            }

            // Tombol Selanjutnya
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
            const totalPages = Math.ceil($items.length / rowsPerPage);
            if (currentPage < totalPages) showPage(currentPage + 1);
        });

        // Jalankan saat pertama kali load
        showPage(1);
    });
</script>

@endsection
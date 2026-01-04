@extends('layouts.app_admin', ['title' => 'Gaji Guru'])

@section('content')

<style>
    .content-wrapper { padding: 20px; }
    
    /* --- STYLE PENCARIAN --- */
    .guru-search { margin-bottom: 25px; }
    .search-input-wrapper { position: relative; display: flex; align-items: center; }
    .search-icon { position: absolute; left: 15px; color: #adb5bd; }
    .search-input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 16px; }
    
    /* --- STYLE GRID GURU --- */
    .guru-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
    .guru-card-link { text-decoration: none; color: inherit; }
    .guru-card { background: #ffffff; display: flex; flex-direction: column; align-items: flex-start; gap: 6px; border-radius: 8px; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.263); transition: transform 0.2s, box-shadow 0.2s; border: 1px solid transparent; padding: 15px; }
    .guru-card:hover { box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transform: translateY(-2px); }
    .nama { font-weight: 600 !important; color: #343a40; font-size: 18px; display: block; }
    .guru-title { font-size: 14px; color: #6c757d; font-weight: 500; }
    .guru-card .guru-info { margin: 0; font-size: 13px; display: block; text-align: left; color: #718096; }
    
    /* --- STYLE PAGINATION (Mirip Pembayaran Siswa) --- */
    .pagination-container { display: flex; gap: 10px; justify-content: center; margin-top: 20px; padding-bottom: 20px; }
    
    .btn-page { 
        border: none; 
        background: transparent; 
        padding: 8px 16px; 
        border-radius: 8px; 
        font-size: 14px; 
        color: #4a5568; 
        cursor: pointer; 
        transition: all 0.2s ease;
    }
    
    .btn-page:hover { background-color: #f7fafc; }
    
    .btn-page.active { 
        background-color: #ebf4ff; 
        color: #3182ce; 
        font-weight: 600; 
    }
    
    .btn-page.next, .btn-page.prev { 
        background-color: #c3dafe; 
        color: #1a365d; 
        font-weight: 500; 
    }
    
    .btn-page:disabled { 
        cursor: default; 
        background-color: #f7fafc; 
        color: #cbd5e0; 
    }
</style>

<div class="content-wrapper">
    {{-- Pencarian --}}
    <div class="guru-search mb-4">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Cari Guru..." />
        </div>
    </div>

    {{-- Grid Kartu Guru --}}
    <div class="guru-grid" id="guruGrid">
        @foreach($guru as $guru)
        <a href="{{ route('admin_detail_pencatatan_gaji_guru', $guru->id) }}" class="guru-card-link guru-item">
            <div class="guru-card">
                <span class="nama">{{ $guru->nama }}</span>
                <div class="guru-info">
                    <span class="guru-title">Guru Mapel: {{ $guru->mapel }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Container Pagination --}}
    <div class="pagination-container" id="paginationGuru"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // --- KONFIGURASI ---
    const rowsPerPage = 10; // Menampilkan 6 kartu per halaman
    const $items = $("#guruGrid .guru-item");
    const $paginationContainer = $("#paginationGuru");
    let currentPage = 1;

    // --- FUNGSI TAMPILKAN HALAMAN ---
    function showPage(page) {
        currentPage = page;
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Reset display
        $items.hide().slice(start, end).fadeIn(300);
        
        renderButtons();
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }

    // --- FUNGSI RENDER TOMBOL PAGINATION (STYLE BARU) ---
    function renderButtons() {
        const totalRows = $items.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);
        
        $paginationContainer.empty();

        if (totalPages <= 1) return;

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
    $(document).on("click", ".num", function() {
        showPage($(this).data("page"));
    });

    $(document).on("click", ".prev", function() {
        if (currentPage > 1) showPage(currentPage - 1);
    });

    $(document).on("click", ".next", function() {
        const totalPages = Math.ceil($items.length / rowsPerPage);
        if (currentPage < totalPages) showPage(currentPage + 1);
    });

    // --- LOGIKA PENCARIAN ---
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();

        if (value.length > 0) {
            $paginationContainer.hide();
            $items.filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        } else {
            $paginationContainer.show();
            showPage(1);
        }
    });

    // Inisialisasi tampilan awal
    showPage(1);
});
</script>

@endsection
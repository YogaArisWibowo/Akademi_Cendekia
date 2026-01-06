@extends('layouts.app_admin', ['title' => 'Laporan Perkembangan Siswa'])
@section('content')

{{-- Load jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    /* Style Pagination JS */
    .pagination-wrapper { display: flex; justify-content: center; align-items: center; padding: 20px 0; gap: 5px; }
    .btn-page { margin: 0 2px; border-radius: 8px; padding: 8px 15px; background-color: transparent; color: #6c757d; border: 1px solid transparent; font-weight: 500; transition: all 0.2s; cursor: pointer; }
    .btn-page:hover { background-color: #f1f1f1; }
    .btn-page.active { background-color: #c9d6ff; color: #3f51b5; font-weight: bold; }
    .btn-page.prev-next { background-color: #e0eaff; color: #3f51b5; }
    .btn-page:disabled { background-color: #f8f9fa; color: #adb5bd; cursor: not-allowed; }

    .controls-group { display: flex; gap: 15px; margin-bottom: 20px; }
    .filter-select { height: 35px; width: 120px; border-radius: 8px; border: 1px solid #d1d5db; padding: 0 10px; font-size: 13px; background-color: white; border-color: transparent !important; cursor: pointer; box-shadow: 0 3px 3px rgba(0, 0, 0, 0.203); }
</style>

<div class="content-wrapper">

    {{-- FILTER FORM --}}
    <div class="controls-group">
        <form method="GET" action="{{ route('admin_Laporan_Perkembangan_Siswa') }}" id="filterForm">
            <select name="jenjang" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                <option value="" {{ request('jenjang') == '' ? 'selected' : '' }}>Semua Jenjang</option>
                <option value="TK" {{ request('jenjang') == 'TK' ? 'selected' : '' }}>TK</option>
                <option value="SD" {{ request('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                <option value="SMP" {{ request('jenjang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                <option value="SMA" {{ request('jenjang') == 'SMA' ? 'selected' : '' }}>SMA</option>
            </select>
        </form>
    </div>

    {{-- Grid Kartu Siswa --}}
    <div class="guru-grid" id="siswaGrid">
        @forelse($siswas as $siswa)
        <div class="siswa-item"> {{-- Wrapper untuk JS Pagination --}}
            {{-- Pastikan route detail menerima ID --}}
            <a href="{{ route('admin_detail_laporan_perkembangan_siswa', ['id' => $siswa->id]) }}" class="guru-card-link">
                <div class="guru-card">
                    <span class="nama">{{ $siswa->nama }}</span>
                    <div class="guru-info">
                        <span class="guru-title">Jenjang: {{ $siswa->jenjang }}</span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="alert alert-info w-100" style="grid-column: span 2;">
            Data siswa tidak ditemukan.
        </div>
        @endforelse
    </div>

    {{-- Container Pagination JS --}}
    <div id="paginationContainer" class="pagination-wrapper">
        {{-- Tombol digenerate via JS --}}
    </div>
</div>

<script>
    $(document).ready(function() {
        // --- KONFIGURASI ---
        const rowsPerPage = 10; // Jumlah kartu per halaman
        const $items = $("#siswaGrid .siswa-item");
        const $paginationContainer = $("#paginationContainer");
        let currentPage = 1;

        if ($items.length === 0) {
            $paginationContainer.hide();
            return;
        }

        // --- FUNGSI TAMPILKAN HALAMAN ---
        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            $items.hide().slice(start, end).fadeIn(300);
            renderButtons();
        }

        // --- FUNGSI RENDER TOMBOL ---
        function renderButtons() {
            const totalRows = $items.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            
            $paginationContainer.empty();

            if (totalPages <= 1) return;

            // Tombol Sebelumnya
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            $paginationContainer.append(`<button class="btn-page prev-next prev" ${prevDisabled}>Sebelumnya</button>`);

            // Tombol Angka
            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                $paginationContainer.append(`<button class="btn-page num ${activeClass}" data-page="${i}">${i}</button>`);
            }

            // Tombol Selanjutnya
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            $paginationContainer.append(`<button class="btn-page prev-next next" ${nextDisabled}>Selanjutnya</button>`);
        }

        // --- EVENT LISTENER ---
        $(document).on("click", ".num", function() { showPage($(this).data("page")); });
        $(document).on("click", ".prev", function() { if (currentPage > 1) showPage(currentPage - 1); });
        $(document).on("click", ".next", function() { 
            const totalPages = Math.ceil($items.length / rowsPerPage);
            if (currentPage < totalPages) showPage(currentPage + 1); 
        });

        showPage(1);
    });
</script>

@endsection
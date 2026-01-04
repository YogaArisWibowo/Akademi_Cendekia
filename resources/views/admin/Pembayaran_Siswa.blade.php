@extends('layouts.app_admin', ['title' => 'Pembayaran Siswa'])

@section('content')

<style>
    .content-wrapper { padding: 20px; }
    .siswa-search { width: 250px; }
    .search-input-wrapper { position: relative; width: 100%; }
    
    .search-input {
        height: 35px; width: 100%; padding: 0 15px 0 40px;
        border: 2px solid #d1d5db; border-radius: 8px; font-size: 14px; background-color: white;
    }

    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #adb5bd; z-index: 2; }

    /* GRID SISTEM */
    .siswa-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .siswa-card-link { text-decoration: none; color: inherit; }

    .siswa-card {
        background: #ffffff; display: flex; flex-direction: column; align-items: flex-start;
        gap: 6px; border-radius: 8px; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s, box-shadow 0.2s; border: 1px solid transparent; padding: 15px;
    }

    .siswa-card:hover { box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transform: translateY(-2px); }

    .nama { font-weight: 600 !important; color: #343a40; font-size: 18px; display: block; line-height: 1.2; }
    .siswa-info { margin: 0; font-size: 13px; display: block; text-align: left; color: #718096; }

    .left-controls { display: flex; align-items: center; gap: 20px; margin-bottom: 25px; padding: 0 20px; }
    .controls-group { display: flex; gap: 15px; }

    .filter-select {
        height: 35px; width: 120px; border-radius: 8px; border: none; padding: 0 10px;
        font-size: 13px; background-color: white; cursor: pointer;
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.15);
    }

    /* STANDAR PAGINATION BOSS */
    .pagination-container { display: flex; gap: 10px; justify-content: center; margin-top: 20px; }
    .btn-page { border: none; background: transparent; padding: 8px 16px; border-radius: 8px; font-size: 14px; color: #4a5568; cursor: pointer; }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; }
    .btn-page.next, .btn-page.prev { background-color: #c3dafe; color: #1a365d; font-weight: 500; }
    .btn-page:disabled { cursor: default; background-color: #f7fafc; color: #cbd5e0; }
</style>

<form id="filterForm" action="{{ route('admin_Pembayaran_Siswa') }}" method="GET" class="left-controls">
    <div class="siswa-search">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" name="search" id="searchInput" class="search-input" placeholder="Cari Nama..." value="{{ request('search') }}" />
        </div>
    </div>

    <div class="controls-group">
        <select name="jenjang" class="filter-select" onchange="this.form.submit()">
            <option value="" selected disabled>Jenjang</option>
            <option value="">Semua Jenjang</option>
            @foreach(['TK', 'SD', 'SMP', 'SMA'] as $jenjang)
                <option value="{{ $jenjang }}" {{ request('jenjang') == $jenjang ? 'selected' : '' }}>{{ $jenjang }}</option>
            @endforeach
        </select>

        <select name="kelas" class="filter-select" onchange="this.form.submit()">
            <option value="" selected disabled>Kelas</option>
            <option value="">Semua Kelas</option>
            @foreach(['A','B','1','2','3','4','5','6','7','8','9','10','11','12'] as $kelas)
                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
            @endforeach
        </select>
    </div>
</form>

<div class="content-wrapper">
    <div class="siswa-grid" id="siswaGrid">
        @forelse($siswa as $item)
            <a href="{{ route('admin_detail_pembayaran_siswa', $item->id) }}" class="siswa-card-link">
                <div class="siswa-card">
                    <span class="nama">{{ $item->nama }}</span>
                    <div class="siswa-info">
                        <span class="siswa-title" style="color: #6c757d; font-weight: 500;">Kelas/Jenjang: {{ $item->kelas }} {{ $item->jenjang }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column: span 2; text-align: center; padding: 50px; color: #6c757d;">
                <p>Data siswa tidak ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-container" id="paginationSiswa"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function setupPagination(wrapperId, paginationId) {
            const rowsPerPage = 10; // Munculkan 10 data
            let currentPage = 1;
            
            const $wrapper = $('#' + wrapperId);
            const $container = $('#' + paginationId);
            
            function render() {
                // Cari kartu siswa
                const $items = $wrapper.find('.siswa-card-link');
                const totalItems = $items.length;
                const totalPages = Math.ceil(totalItems / rowsPerPage);
                
                $container.empty();
                
                // STANDAR BOSS: Hanya muncul jika data > 10
                if (totalPages > 1) {
                    $container.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                    
                    for (let i = 1; i <= totalPages; i++) {
                        $container.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    
                    $container.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
                }
                
                // Tampilkan kartu sesuai pagination
                $items.hide().slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();
            }

            $container.on('click', '.num', function() { currentPage = $(this).data('page'); render(); });
            $container.on('click', '.prev', function() { if (currentPage > 1) { currentPage--; render(); } });
            $container.on('click', '.next', function() { 
                const totalItems = $wrapper.find('.siswa-card-link').length;
                if (currentPage < Math.ceil(totalItems / rowsPerPage)) { currentPage++; render(); } 
            });

            render();
        }

        setupPagination('siswaGrid', 'paginationSiswa');

        // Search Auto-Submit
        let searchTimer;
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                $('#filterForm').submit();
            }, 500);
        });
    });
</script>

@endsection
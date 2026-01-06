@extends('layouts.app_admin', ['title' => 'Absensi Guru']) 

@section('content')

<style>
    /* --- DESKTOP DEFAULT --- */
    .back {
        background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px;
        color: white; font-weight: 500; font-size: 14px; cursor: pointer;
        display: flex; align-items: center; justify-content: center; margin-bottom: 20px; text-decoration: none;
        transition: 0.3s;
    }
    .back:hover { background-color: #b0b0b0; }
    .back i { padding-right: 5px; }

    /* Header Wrapper Desktop */
    .header-custom-wrapper {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-top: 20px; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;
    }
    
    .profile-info h3 { margin: 0; font-weight: 700; color: #1f2937; font-size: 1.5rem; }
    
    .left-controls { display: flex; align-items: flex-end; gap: 15px; }
    .controls-group form { display: flex; gap: 10px; }
    
    /* Style Filter Desktop */
    .filter-select {
        height: 38px; width: 120px; border-radius: 8px; border: 1px solid #d1d5db;
        padding: 0 10px; font-size: 13px; cursor: pointer; background-color: white;
        border-color: transparent !important; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Style Tombol Unduh Desktop */
    .btn-download-green {
        background-color: #00cb0a; color: white; border: none; border-radius: 8px;
        height: 38px; padding: 0 20px; font-weight: 600; cursor: pointer;
        transition: 0.3s; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 14px;
    }
    .btn-download-green:hover { background-color: #00a008; }

    /* --- TABLE STYLE --- */
    .table-container { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; padding-bottom: 5px; }
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; min-width: 800px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 14px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 14px; white-space: nowrap; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }

    .img-thumbnail-mini { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; transition: transform 0.2s; }
    .img-thumbnail-mini:hover { transform: scale(1.1); box-shadow: 0 4px 6px rgba(0,0,0,0.2); }

    /* --- PAGINATION --- */
    .pagination-container { display: flex; justify-content: center; gap: 5px; margin-top: 20px; flex-wrap: wrap; }
    .btn-page { border: 1px solid #dee2e6; background-color: white; color: #0d6efd; padding: 6px 12px; border-radius: 4px; cursor: pointer; transition: all 0.2s; font-size: 14px; }
    .btn-page:hover:not(:disabled) { background-color: #e9ecef; }
    .btn-page.active { background-color: #0d6efd; color: white; border-color: #0d6efd; }
    .btn-page:disabled { color: #6c757d; background-color: #f8f9fa; border-color: #dee2e6; cursor: default; }

    /* --- MOBILE RESPONSIVE FIX --- */
    @media screen and (max-width: 768px) {
        /* 1. Layout Header jadi Kolom & Rata Kiri */
        .header-custom-wrapper {
            flex-direction: column !important;
            align-items: flex-start !important; /* Paksa rata kiri */
            gap: 15px;
        }

        .left-controls {
            flex-direction: column !important;
            align-items: flex-start !important; /* Paksa rata kiri */
            width: 100%;
            gap: 10px;
        }

        /* 2. Nama Guru */
        .profile-info {
            width: 100%;
            text-align: left !important; /* Pastikan teks di kiri */
        }
        .profile-info h3 { 
            font-size: 1.2rem; 
            text-align: left;
        }

        /* 3. Filter jadi Kecil (Compact) */
        .controls-group {
            width: 100%;
        }
        .controls-group form {
            display: flex;
            justify-content: flex-start; /* Nempel kiri */
            gap: 8px;
        }

        .filter-select {
            width: 95px !important;  /* Lebar saya kunci jadi kecil */
            height: 30px !important; /* Tinggi lebih pendek */
            font-size: 11px !important;
            padding: 0 5px;
        }

        /* 4. Tombol Unduh Kecil */
        .btn-download-green {
            width: auto !important;
            height: 30px !important;
            font-size: 11px !important;
            padding: 0 15px;
            align-self: flex-start; /* Pastikan dia nempel kiri, bukan tengah/kanan */
        }

        /* Style Tabel Mobile */
        .table-general thead th, .table-general tbody td {
            padding: 8px 6px;
            font-size: 12px;
        }
        .img-thumbnail-mini { width: 40px; height: 40px; }
    }

    /* PRINT */
    .print-only-title { display: none; }
    @media print {
        @page { margin: 0; size: landscape; }
        body { margin: 1cm; background-color: white !important; }
        body * { visibility: hidden; } 
        .table-container, .table-container * { visibility: visible; } 
        .table-container { position: absolute; left: 0; top: 0; width: 100% !important; overflow: visible; }
        .print-only-title { display: block !important; visibility: visible !important; text-align: center; margin-bottom: 25px; font-size: 20px; font-weight: bold; color: #1f2937; }
        .table-general th { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; }
        .pagination-container, .back, .header-custom-wrapper { display: none !important; }
    }
</style>

{{-- Tombol Kembali --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Absensi') }}" style="text-decoration: none;">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

{{-- Header: Nama & Filter --}}
<div class="header-custom-wrapper">
    <div class="left-controls">
        <div class="profile-info">
            <h3>{{ $guru->nama }}</h3>
        </div>

        <div class="controls-group">
            <form action="{{ URL::current() }}" method="GET">
                <select name="bulan" class="filter-select" onchange="this.form.submit()">
                    <option value="">Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun" class="filter-select" onchange="this.form.submit()">
                    <option value="">Tahun</option>
                    @for($y = date('Y'); $y >= 2024; $y--)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>
    
    {{-- Tombol Download dipisah dari group kiri agar responsif lebih mudah --}}
    <button class="btn-download-green" onclick="window.print()">
        <i class="ri-printer-line" style="margin-right:5px;"></i> Unduh / Cetak
    </button>
</div>

{{-- Kontainer Utama --}}
<div class="table-container">
    {{-- Judul Print --}}
    <div class="print-only-title">
        LAPORAN ABSENSI GURU: {{ strtoupper($guru->nama) }}
    </div>

    <table class="table-general" id="absensiGuruTable">
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
        <tbody>
            @forelse($absensi as $item)
            <tr class="absensi-item">
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H.i') }}</td>
                <td>{{ $item->mapel ?? '-' }}</td>
                <td>
                    @if($item->bukti_foto)
                        <a href="{{ asset('bukti_absensi/' . $item->bukti_foto) }}" target="_blank">
                            <img src="{{ asset('bukti_absensi/' . $item->bukti_foto) }}" 
                                alt="Bukti" 
                                class="img-thumbnail-mini"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/60?text=No+Img';">
                        </a>
                    @else - @endif
                </td>
                {{-- Gunakan div dengan max-width agar teks catatan panjang bisa wrap di HP --}}
                <td>
                    <div style="max-width: 200px; white-space: normal;">
                        {{ $item->laporan_kegiatan ?? '-' }}
                    </div>
                </td>
            </tr>
            @empty
            <tr id="serverNoData">
                <td colspan="7" class="text-center py-4">Data tidak ditemukan.</td>
            </tr>
            @endforelse
            
            <tr id="noDataRow" style="display: none;">
                <td colspan="7" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
            </tr>
        </tbody>
    </table>

    <div class="pagination-container" id="paginationControls"></div>
</div>

{{-- JAVASCRIPT (TIDAK BERUBAH) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function setupPagination(tableId, paginationId) {
            const rowsPerPage = 10; 
            let currentPage = 1;
            
            const $table = $('#' + tableId);
            const $pagination = $('#' + paginationId);
            const $serverNoData = $('#serverNoData'); 
            
            const $rows = $table.find('tbody tr.absensi-item');
            const totalItems = $rows.length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            
            if (totalItems === 0) {
                if ($serverNoData.length) $serverNoData.show();
                $pagination.empty();
                return;
            } else {
                if ($serverNoData.length) $serverNoData.hide();
            }

            function render() {
                if (currentPage > totalPages) currentPage = 1;
                if (currentPage < 1) currentPage = 1;

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                $rows.hide().slice(start, end).show();
                $pagination.empty();
                
                if (totalPages > 1) {
                    $pagination.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`);
                    
                    // Logic simple untuk pagination responsive (max 5 angka)
                    let startPage = Math.max(1, currentPage - 2);
                    let endPage = Math.min(totalPages, currentPage + 2);

                    for (let i = startPage; i <= endPage; i++) {
                        $pagination.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    
                    $pagination.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`);
                }
            }

            $pagination.on('click', '.num', function() { currentPage = $(this).data('page'); render(); });
            $pagination.on('click', '.prev', function() { if (currentPage > 1) { currentPage--; render(); } });
            $pagination.on('click', '.next', function() { if (currentPage < totalPages) { currentPage++; render(); } });

            render();
        }
        setupPagination('absensiGuruTable', 'paginationControls');
    });
</script>

@endsection
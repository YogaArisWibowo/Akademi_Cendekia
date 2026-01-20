@extends('layouts.app_admin', ['title' => 'Laporan Absensi Siswa']) 

@section('content')

{{-- ========================================================== --}}
{{--                      BAGIAN STYLE (CSS)                    --}}
{{-- ========================================================== --}}
<style>
    /* -------------------------------------------------------
       1. STYLE TAMPILAN WEB (LAYOUT ASLI)
       ------------------------------------------------------- */
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

    /* --- TABLE STYLE (WEB) --- */
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
        .header-custom-wrapper { flex-direction: column !important; align-items: flex-start !important; gap: 15px; }
        .left-controls { flex-direction: column !important; align-items: flex-start !important; width: 100%; gap: 10px; }
        .profile-info { width: 100%; text-align: left !important; }
        .profile-info h3 { font-size: 1.2rem; text-align: left; }
        .controls-group { width: 100%; }
        .controls-group form { display: flex; justify-content: flex-start; gap: 8px; }
        .filter-select { width: 95px !important; height: 30px !important; font-size: 11px !important; padding: 0 5px; }
        .btn-download-green { width: auto !important; height: 30px !important; font-size: 11px !important; padding: 0 15px; align-self: flex-start; }
        .table-general thead th, .table-general tbody td { padding: 8px 6px; font-size: 12px; }
        .img-thumbnail-mini { width: 40px; height: 40px; }
    }

    /* -------------------------------------------------------
       2. PENGATURAN CETAK (PRINT STYLE)
       ------------------------------------------------------- */
    
    /* Default: Sembunyikan area cetak di layar komputer */
    #print-area { display: none; }

    @media print {
        /* MENGHILANGKAN HEADER/FOOTER BROWSER */
        @page {
            margin: 0; 
            size: landscape; 
        }
        
        body {
            margin: 0;
            padding: 0;
            background-color: white;
        }

        /* Sembunyikan elemen website asli */
        .web-view-wrapper, .web-view-wrapper * { display: none !important; }
        body * { visibility: hidden; }
        
        /* Tampilkan HANYA area print */
        #print-area, #print-area * { visibility: visible; }
        
        /* Layout Halaman Cetak */
        #print-area {
            display: block !important;
            position: absolute; left: 0; top: 0; width: 100%;
            font-family: sans-serif; color: #000; font-size: 12px;
            background-color: white; 
            padding: 1.5cm 2cm; 
            box-sizing: border-box;
        }

        /* HEADER FORMAL */
        .print-header { width: 100%; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .print-title { font-size: 20px; font-weight: bold; color: #1a73e8 !important; text-transform: uppercase; -webkit-print-color-adjust: exact; }
        .print-subtitle { font-size: 14px; margin-top: 5px; }

        /* Tabel Formal */
        .table-formal { width: 100%; border-collapse: collapse; margin-bottom: 20px; margin-top: 20px; border: 1px solid #000; }
        .table-formal th, .table-formal td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        .table-formal th { background-color: #f2f2f2 !important; font-weight: bold; text-align: center; -webkit-print-color-adjust: exact; }
        
        /* Info Siswa Wrapper */
        .info-table { width: 100%; margin-bottom: 10px; font-size: 13px; }
        .info-table td { padding: 4px 0; vertical-align: top; }

        /* Tanda Tangan */
        .signature-container { float: right; width: 220px; text-align: center; margin-top: 40px; page-break-inside: avoid; }
        .qr-code { width: 80px; height: 80px; margin: 10px auto; object-fit: contain; }

        /* Helpers */
        .text-center { text-align: center; }
        .img-print-mini { width: 50px; height: 50px; object-fit: cover; border: 1px solid #ccc; }
    }
</style>

{{-- ========================================================== --}}
{{--                BAGIAN TAMPILAN WEB (ASLI)                  --}}
{{-- ========================================================== --}}

<div class="web-view-wrapper">
    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin_Absensi') }}" style="text-decoration: none;">
            <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
        </a>
    </div>

    {{-- Header & Filter --}}
    <div class="header-custom-wrapper">
        <div class="left-controls">
            <div class="profile-info">
                <h3>{{ $siswa->nama }}</h3>
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
        
        <button class="btn-download-green" onclick="window.print()">
            <i class="ri-printer-line" style="margin-right:5px;"></i> Unduh / Cetak
        </button>
    </div>

    {{-- Tabel Data Web --}}
    <div class="table-container">
        <table class="table-general" id="absensiTable">
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
                        @if($item->bukti)
                            <a href="{{ asset('bukti_absensi/' . $item->bukti) }}" target="_blank">
                                <img src="{{ asset('bukti_absensi/' . $item->bukti) }}" 
                                    alt="Bukti" 
                                    class="img-thumbnail-mini"
                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/60?text=No+Img';">
                            </a>
                        @else - @endif
                    </td>
                    <td>
                        <div style="max-width: 200px; white-space: normal;">
                            {{ $item->catatan ?? '-' }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="serverNoData">
                    <td colspan="7" class="text-center py-4">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container" id="paginationControls"></div>
    </div>
</div>
{{-- End Web View Wrapper --}}


{{-- ========================================================== --}}
{{--               BAGIAN TAMPILAN CETAK (PRINT)                --}}
{{-- ========================================================== --}}

<div id="print-area">
    
    {{-- 1. Header Formal --}}
    <div class="print-header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="print-title">AKADEMI CENDEKIA</div>
                    <div class="print-subtitle">Laporan Absensi Siswa</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- 2. Info Siswa --}}
    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nama Siswa</strong></td>
            <td width="2%">:</td>
            <td width="40%">{{ $siswa->nama }}</td>
            
            <td width="15%"><strong>Periode</strong></td>
            <td width="2%">:</td>
            <td>
                {{-- Menggunakan (int) casting agar Carbon tidak error --}}
                @if(request('bulan')) 
                    {{ \Carbon\Carbon::createFromDate(null, (int) request('bulan'), 1)->translatedFormat('F') }} 
                @endif
                
                @if(request('tahun')) {{ request('tahun') }} @else @if(!request('bulan')) Semua Periode @endif @endif
            </td>
        </tr>
    </table>

    {{-- 3. Tabel Data Formal --}}
    <table class="table-formal">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Hari</th>
                <th width="12%">Tanggal</th>
                <th width="8%">Waktu</th>
                <th width="15%">Mapel</th>
                <th width="10%">Bukti</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}.</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('H.i') }}</td>
                <td>{{ $item->mapel ?? '-' }}</td>
                <td class="text-center">
                    @if($item->bukti)
                        <img src="{{ asset('bukti_absensi/' . $item->bukti) }}" 
                             alt="Bukti" 
                             class="img-print-mini"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/50?text=No+Img';">
                    @else - @endif
                </td>
                <td>{{ $item->catatan ?? '-' }}</td>
            </tr>
            @endforeach
            
            @if($absensi->isEmpty())
            <tr><td colspan="7" class="text-center">Tidak ada data absensi.</td></tr>
            @endif
        </tbody>
    </table>

    {{-- 4. Tanda Tangan --}}
    <div class="signature-container">
        <div style="margin-bottom: 5px;">{{ date('d F Y') }}</div>
        <div style="font-weight: bold; margin-bottom: 10px;">Pemilik Bimbel</div>

        {{-- Gambar Tanda Tangan --}}
        <img src="{{ asset('img/tanda_tangan_yoga.png') }}" class="qr-code" alt="Tanda Tangan">
    </div>

</div>

{{-- JAVASCRIPT (Pagination Web) --}}
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
                    $pagination.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                    
                    let startPage = Math.max(1, currentPage - 2);
                    let endPage = Math.min(totalPages, currentPage + 2);

                    for (let i = startPage; i <= endPage; i++) {
                        $pagination.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    
                    $pagination.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
                }
            }

            $pagination.on('click', '.num', function() { currentPage = $(this).data('page'); render(); });
            $pagination.on('click', '.prev', function() { if (currentPage > 1) { currentPage--; render(); } });
            $pagination.on('click', '.next', function() { if (currentPage < totalPages) { currentPage++; render(); } });

            render();
        }
        setupPagination('absensiTable', 'paginationControls');
    });
</script>

@endsection
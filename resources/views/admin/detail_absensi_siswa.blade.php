@extends('layouts.app_admin', ['title' => 'Absensi Siswa']) 

@section('content')

<style>
    /* --- CSS UTAMA (Bawaan) --- */
    .back {
        background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px;
        color: white; font-weight: 500; font-size: large; cursor: pointer;
        display: flex; align-items: center; justify-content: center; margin-bottom: 20px; text-decoration: none;
        transition: 0.3s;
    }
    .back:hover { background-color: #b0b0b0; }
    .back i { padding-right: 5px; }

    .header-custom-wrapper {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-top: 20px; margin-bottom: 30px;
    }
    .profile-info h3 { margin: 0; font-weight: 700; color: #1f2937; }
    .left-controls { display: flex; align-items: flex-end; gap: 50px; }
    .controls-group { display: flex; gap: 10px; }
    .filter-select {
        height: 35px; width: 120px; border-radius: 8px; border: 1px solid #d1d5db;
        padding: 0 10px; font-size: 13px; cursor: pointer; background-color: white;
        border-color: transparent !important; box-shadow: 0 3px 3px rgba(0, 0, 0, 0.203);
    }
    .btn-download-green {
        background-color: #00cb0a; color: white; border: none; border-radius: 8px;
        height: 35px; padding: 0 15px; font-weight: 600; cursor: pointer;
        transition: 0.3s;
    }
    .btn-download-green:hover { background-color: #00a008; }

    /* --- CSS TABEL --- */
    .table-container { width: 100%; overflow-x: auto; } /* Wrapper agar aman */
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }

    /* --- CSS PAGINATION BARU --- */
    .pagination-container {
        display: flex; justify-content: center; gap: 5px; margin-top: 20px;
    }
    .btn-page {
        border: 1px solid #dee2e6; background-color: white; color: #0d6efd;
        padding: 6px 12px; border-radius: 4px; cursor: pointer; transition: all 0.2s; font-size: 14px;
    }
    .btn-page:hover:not(:disabled) { background-color: #e9ecef; }
    .btn-page.active { background-color: #0d6efd; color: white; border-color: #0d6efd; }
    .btn-page:disabled { color: #6c757d; background-color: #f8f9fa; border-color: #dee2e6; cursor: default; }

    /* --- PRINT STYLES --- */
    .print-only-title { display: none; }

    @media print {
        @page { margin: 0; }
        body { margin: 1.6cm; background-color: white !important; }
        body * { visibility: hidden; } 
        
        .table-container, .table-container * { visibility: visible; } 
        .table-container { position: absolute; left: 0; top: 0; width: 100% !important; }

        .print-only-title { 
            display: block !important; visibility: visible !important;
            text-align: center; margin-bottom: 25px; font-size: 20px;
            font-weight: bold; color: #1f2937;
        }

        .table-general th { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; }

        /* Sembunyikan Pagination Saat Print */
        .pagination-container, .back, .header-custom-wrapper { display: none !important; }
        a[href]::after { content: none !important; }
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

{{-- Tombol Kembali --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Absensi') }}" style="text-decoration: none;">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

{{-- Header & Filter --}}
<div class="header-custom-wrapper">
    <div class="left-controls">
        <div class="profile-info"><h3>{{ $siswa->nama }}</h3></div>
        <div class="controls-group">
            <form action="{{ URL::current() }}" method="GET" style="display: flex; gap: 10px;">
                <select name="bulan" class="filter-select" onchange="this.form.submit()">
                    <option value="">Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
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
    <button class="btn-download-green" onclick="window.print()">Unduh</button>
</div>

{{-- Tabel Data --}}
<div class="table-container">
    <div class="print-only-title">LAPORAN ABSENSI SISWA: {{ strtoupper($siswa->nama) }}</div>
    
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
                {{-- Gunakan loop iteration agar nomor urut tetap 1 s/d selesai --}}
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
                                {{-- Tambahan: Jika gambar error/tidak ketemu, ganti dengan placeholder --}}
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/60?text=No+Img';">
                        </a>
                    @else - @endif
                </td>
                <td>{{ $item->catatan ?? '-' }}</td>
            </tr>
            @empty
            {{-- Ini akan otomatis dihandle JS (hidden), tapi tetap disediakan utk server side --}}
            <tr id="serverNoData"><td colspan="7" class="text-center py-4">Data tidak ditemukan.</td></tr>
            @endforelse

            {{-- Baris Pesan Kosong Khusus Script --}}
            <tr id="noDataRow" style="display: none;">
                <td colspan="7" class="text-center py-4 text-muted">
                    Data tidak ditemukan.
                </td>
            </tr>
        </tbody>
    </table>

    {{-- CONTAINER PAGINATION JS --}}
    <div class="pagination-container" id="paginationControls"></div>
</div>

{{-- JAVASCRIPT PAGINATION --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        
        function setupPagination(tableId, paginationId) {
            const rowsPerPage = 10; 
            let currentPage = 1;
            
            const $table = $('#' + tableId);
            const $pagination = $('#' + paginationId);
            const $noDataRow = $('#noDataRow');
            const $serverNoData = $('#serverNoData');
            
            // Ambil semua baris data (kecuali baris pesan kosong)
            const $rows = $table.find('tbody tr.absensi-item');
            const totalItems = $rows.length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            
            // Jika data memang kosong dari server
            if (totalItems === 0) {
                if ($serverNoData.length) $serverNoData.show();
                $pagination.empty();
                return;
            } else {
                if ($serverNoData.length) $serverNoData.hide();
            }

            function render() {
                // Validasi Page
                if (currentPage > totalPages) currentPage = 1;
                if (currentPage < 1) currentPage = 1;

                // Hitung Index
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                // Tampilkan/Sembunyikan Baris
                $rows.hide().slice(start, end).show();

                // Render Tombol Pagination
                $pagination.empty();
                
                // Hanya muncul jika halaman > 1
                if (totalPages > 1) {
                    // Previous
                    $pagination.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                    
                    // Angka
                    for (let i = 1; i <= totalPages; i++) {
                        $pagination.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    
                    // Next
                    $pagination.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
                }
            }

            // Event Handlers
            $pagination.on('click', '.num', function() { currentPage = $(this).data('page'); render(); });
            $pagination.on('click', '.prev', function() { if (currentPage > 1) { currentPage--; render(); } });
            $pagination.on('click', '.next', function() { if (currentPage < totalPages) { currentPage++; render(); } });

            // Initial Render
            render();
        }

        // Jalankan Fungsi
        setupPagination('absensiTable', 'paginationControls');
    });
</script>

@endsection
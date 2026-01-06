@extends('layouts.app_admin', ['title' => 'Laporan Perkembangan Siswa'])

@section('content')

<style>
    /* --- STYLE UMUM (TAMPILAN WEB) --- */
    .back {
        background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px;
        color: white; font-weight: 500; font-size: large; cursor: pointer;
        display: flex; align-items: center; justify-content: center; margin-bottom: 20px; text-decoration: none;
    }
    .back i { padding-right: 5px; }

    .header-custom-wrapper {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-top: 20px; margin-bottom: 30px;
    }
    .profile-info h3 { margin: 0; font-weight: 700; color: #1f2937; }
    
    .left-controls { width: 100%; max-width: 400px; }
    
    .custom-card {
        background: #ffffff; border-radius: 15px; padding: 15px 20px; margin-top: 15px;
        border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        display: flex; align-items: center; height: auto; width: fit-content;
    }
    .card-body-content { display: flex; gap: 20px; align-items: center; }
    .name { margin: 0; font-weight: 600; color: #64748b; font-size: 0.95rem; text-transform: uppercase; }
    
    .badge-number {
        background-color: #00cb0a; color: white; width: 38px; height: 38px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: 600; box-shadow: 0 4px 6px rgba(43, 108, 176, 0.3);
    }

    .btn-download-green {
        background-color: #00cb0a; color: white; border: none; border-radius: 8px;
        height: 35px; padding: 0 15px; font-weight: 600; cursor: pointer;
    }

    /* --- STYLE TABEL --- */
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; border-bottom: 1px solid #eee; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }

    /* Judul ini disembunyikan di layar, hanya muncul saat diprint */
    .print-only-title { display: none; }

    /* --- PENGATURAN CETAK / PDF --- */
    @media print {
        /* 1. Hilangkan margin browser */
        @page { margin: 0; size: auto; }
        body { margin: 1.6cm; background-color: white !important; }

        /* 2. Sembunyikan SEMUA elemen website (Sidebar, Navbar, Tombol, dll) */
        body * { visibility: hidden; } 
        
        /* 3. Tampilkan kembali hanya area tabel wrapper dan isinya */
        .table-container, .table-container * { visibility: visible; } 
        
        /* 4. Posisikan area tabel di pojok kiri atas */
        .table-container {
            position: absolute; left: 0; top: 0; width: 100% !important;
        }

        /* 5. Tampilkan Judul Khusus Print */
        .print-only-title { 
            display: block !important; 
            visibility: visible !important;
            text-align: center; 
            margin-bottom: 25px;
            color: #1f2937;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .print-only-title h2 { font-size: 24px; margin-bottom: 5px; margin-top: 0; }
        .print-only-title p { font-size: 14px; margin: 2px 0; }

        /* 6. Pastikan warna background tabel tercetak */
        .table-general th { 
            background-color: #CCE0FF !important; 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact;
        }
        .table-general tr:nth-child(even) {
            background-color: #EBF3FF !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* 7. Sembunyikan elemen navigasi yang mungkin tersisa */
        .pagination-wrapper, .back, .header-custom-wrapper, .btn-download-green { display: none !important; }
        a[href]::after { content: none !important; }
    }
</style>

{{-- Tampilan Views: Tombol Kembali --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    {{-- Sesuaikan route ini jika perlu --}}
    <a href="{{ route('admin_Laporan_Perkembangan_Siswa') }}" style="text-decoration: none;">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

{{-- Tampilan Views: Header (Nama, Nilai, Tombol) --}}
<div class="header-custom-wrapper">
    <div class="left-controls">
        <div class="profile-info">
            <h3>{{ $siswas->name }}</h3>
        </div>

        <div class="custom-card">
            <div class="card-body-content">
                <div class="info">
                    <h5 class="name">Nilai Rata-Rata</h5>
                </div>
                <div class="badge-number">{{ $nilai }}</div>
            </div>
        </div>
    </div>
    
    {{-- TOMBOL UNDUH: MENGGUNAKAN WINDOW.PRINT() --}}
    <button class="btn-download-green" onclick="window.print()">Unduh</button>
</div>

{{-- Kontainer Utama yang akan dicetak --}}
<div class="table-container">
    
    {{-- Header Khusus Print (Judul, Nama, Nilai) --}}
    <div class="print-only-title">
        <h2>LAPORAN PERKEMBANGAN SISWA</h2>
        <p><strong>Nama Siswa:</strong> {{ $siswas->nama }}</p>
        <p><strong>Nilai Rata-Rata:</strong> {{ $nilai }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ date('d-m-Y') }}</p>
    </div>

    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari, Tanggal</th>
                <th>Waktu</th>
                <th>Mata Pelajaran</th>
                <th>Catatan Perkembangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $index => $laporan)
            <tr>
                {{-- Penomoran --}}
                <td>
                    {{ method_exists($laporans, 'firstItem') ? $laporans->firstItem() + $index : $index + 1 }}
                </td>
                
                {{-- Hari & Tanggal --}}
                <td>
                    {{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </td>
                
                {{-- Waktu --}}
                <td>{{ \Carbon\Carbon::parse($laporan->waktu)->format('H:i') }}</td>
                
                <td>{{ $laporan->mapel }}</td>
                <td>{{ $laporan->laporan_perkembangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">
                    Belum ada data laporan perkembangan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination (Akan disembunyikan saat print oleh CSS) --}}
    @if(method_exists($laporans, 'hasPages') && $laporans->hasPages())
    <div class="pagination-wrapper mt-4">
        {{ $laporans->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
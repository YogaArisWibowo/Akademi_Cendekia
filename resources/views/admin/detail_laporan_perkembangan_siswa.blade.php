@extends('layouts.app_admin', ['title' => 'Laporan Perkembangan Siswa'])

@section('content')

{{-- ========================================================== --}}
{{--                      BAGIAN STYLE (CSS)                    --}}
{{-- ========================================================== --}}
<style>
    /* -------------------------------------------------------
       1. STYLE TAMPILAN WEB (Sesuai kode asli Anda)
       ------------------------------------------------------- */
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

    /* Tabel Web (Warna Biru Muda) */
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; border-bottom: 1px solid #eee; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }


    /* -------------------------------------------------------
       2. PENGATURAN CETAK (AGAR TAMPILAN BERUBAH SAAT PRINT)
       ------------------------------------------------------- */
    
    /* Default: Sembunyikan area cetak di layar komputer */
    #print-area { display: none; }

    @media print {
        /* --- [TAMBAHAN KHUSUS] MENGHILANGKAN HEADER/FOOTER BROWSER --- */
        @page {
            margin: 0; /* Ini kuncinya: set margin kertas ke 0 */
            size: auto;
        }
        
        body {
            margin: 0;
            padding: 0;
            background-color: white;
        }
        /* ----------------------------------------------------------- */

        /* Sembunyikan semua elemen website asli (Sidebar, Navbar, Tombol, Tabel Web) */
        .web-view-wrapper, .web-view-wrapper * { display: none !important; }
        body * { visibility: hidden; }
        
        /* Tampilkan HANYA area print */
        #print-area, #print-area * { visibility: visible; }
        
        /* Posisikan area print di pojok kiri atas kertas */
        #print-area {
            display: block !important;
            position: absolute; left: 0; top: 0; width: 100%;
            font-family: sans-serif; color: #000; font-size: 12px;
            background-color: white; 
            
            /* Padding diperbesar karena margin kertas kita hilangkan agar tulisan URL hilang.
               Padding ini menggantikan margin kertas agar teks tidak mepet ujung. */
            padding: 1.5cm 2cm; 
            box-sizing: border-box;
        }

        /* --- STYLE KHUSUS PRINT (MENGIKUTI GAYA SLIP GAJI) --- */
        
        /* Header Formal */
        .print-header { width: 100%; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .print-title { font-size: 20px; font-weight: bold; color: #1a73e8 !important; text-transform: uppercase; -webkit-print-color-adjust: exact; }
        .print-subtitle { font-size: 14px; margin-top: 5px; }

        /* Tabel Formal (Garis Hitam Tegas) */
        .table-formal { width: 100%; border-collapse: collapse; margin-bottom: 30px; margin-top: 20px; }
        .table-formal th, .table-formal td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table-formal th { background-color: #f2f2f2 !important; font-weight: bold; text-align: center; -webkit-print-color-adjust: exact; }
        
        /* Tanda Tangan */
        .signature-container { float: right; width: 200px; text-align: center; margin-top: 30px; page-break-inside: avoid; }
        .qr-code { width: 80px; height: 80px; margin: 10px auto; object-fit: contain; }

        /* Helpers */
        .text-center { text-align: center; }
    }
</style>


{{-- ========================================================== --}}
{{--                BAGIAN TAMPILAN WEB (ASLI)                  --}}
{{-- ========================================================== --}}

{{-- Wrapper ini akan HILANG saat diprint --}}
<div class="web-view-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin_Laporan_Perkembangan_Siswa') }}" style="text-decoration: none;">
            <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
        </a>
    </div>

    <div class="header-custom-wrapper">
        <div class="left-controls">
            <div class="profile-info">
                <h3>{{ $siswas->nama ?? $siswas->name }}</h3>
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
        
        <button class="btn-download-green" onclick="window.print()">Unduh</button>
    </div>

    <div class="table-container">
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
                    <td>{{ method_exists($laporans, 'firstItem') ? $laporans->firstItem() + $index : $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
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

        @if(method_exists($laporans, 'hasPages') && $laporans->hasPages())
        <div class="pagination-wrapper mt-4">
            {{ $laporans->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>
{{-- End Web View Wrapper --}}


{{-- ========================================================== --}}
{{--               BAGIAN TAMPILAN CETAK (PRINT)                --}}
{{-- ========================================================== --}}

<div id="print-area">
    
    {{-- 1. Header Formal (Garis Bawah) --}}
    <div class="print-header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="print-title">AKADEMI CENDEKIA</div>
                    <div class="print-subtitle">Laporan Hasil Belajar Siswa</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- 2. Info Siswa --}}
    <table style="width: 100%; font-size: 13px; margin-bottom: 10px;">
        <tr>
            <td width="15%"><strong>Nama Siswa</strong></td>
            <td width="2%">:</td>
            <td width="40%">{{ $siswas->nama }}</td>
            
            <td width="15%"><strong>Jenjang</strong></td>
            <td width="2%">:</td>
            <td>{{ $siswas->jenjang ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nilai Rata-rata</strong></td>
            <td>:</td>
            <td>{{ $nilai }}</td>
        </tr>
    </table>

    {{-- 3. Tabel Data --}}
    <table class="table-formal">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal</th>
                <th width="10%">Waktu</th>
                <th width="20%">Mata Pelajaran</th>
                <th>Catatan Perkembangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $index => $laporan)
            <tr>
                <td class="text-center">{{ $loop->iteration }}.</td>
                <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->locale('id')->isoFormat('d MMMM Y') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($laporan->waktu)->format('H:i') }}</td>
                <td>{{ $laporan->mapel }}</td>
                <td>{{ $laporan->laporan_perkembangan }}</td>
            </tr>
            @endforeach
            
            @if($laporans->isEmpty())
            <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
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

@endsection
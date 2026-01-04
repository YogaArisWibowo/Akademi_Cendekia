@extends('layouts.app_admin', ['title' => 'Absensi Guru']) 

@section('content')

<style>
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
    }

    /* TABEL: WARNA ABU-ABU SESUAI VIEW PERTAMA */
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }


    /* Judul ini disembunyikan di layar, hanya muncul saat diprint */
    .print-only-title { display: none; }

    @media print {
        /* Menghilangkan Header/Footer Otomatis Browser (Tanggal & Judul) */
        @page { margin: 0; }
        body { margin: 1.6cm; background-color: white !important; }

        /* Sembunyikan SEMUA elemen di luar tabel container */
        body * { visibility: hidden; } 
        
        /* Tampilkan kembali hanya area tabel dan isinya */
        .table-container, .table-container * { visibility: visible; } 
        
        .table-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
        }

        /* Judul Nama yang muncul di atas tabel saat diprint */
        .print-only-title { 
            display: block !important; 
            visibility: visible !important;
            text-align: center; 
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            border-bottom: none; /* Menghilangkan Underline agar rapi */
        }

        /* Jaga style warna tabel Boss agar tetap muncul di PDF/Print */
        .table-general th { 
            background-color: #f9fafb !important; 
            -webkit-print-color-adjust: exact; 
        }

        .pagination-wrapper, .back, .header-custom-wrapper { display: none !important; }
        a[href]::after { content: none !important; }
    }
</style>

{{-- Tampilan Views: Tombol Kembali --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Absensi') }}" style="text-decoration: none;">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

{{-- Tampilan Views: Nama & Filter --}}
<div class="header-custom-wrapper">
    <div class="left-controls">
        <div class="profile-info">
            <h3>{{ $guru->nama }}</h3>
        </div>

        <div class="controls-group">
            <form action="{{ URL::current() }}" method="GET" style="display: flex; gap: 10px;">
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
    <button class="btn-download-green" onclick="window.print()">Unduh</button>
</div>

{{-- Kontainer Utama --}}
<div class="table-container">
    {{-- Muncul hanya saat Print --}}
    <div class="print-only-title">
        LAPORAN ABSENSI GURU: {{ strtoupper($guru->nama) }}
    </div>

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
        <tbody>
            @forelse($absensi as $key => $item)
            <tr>
                <td>{{ $absensi->firstItem() + $key }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H.i') }}</td>
                <td>{{ $item->mapel ?? '-' }}</td>
                <td>
                    @if($item->bukti_foto)
                        {{-- Menggunakan asset() karena file ada di public/bukti_absensi --}}
                        <a href="{{ asset('bukti_absensi/' . $item->bukti_foto) }}" target="_blank"><u>Lihat Detail</u></a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->laporan_kegiatan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrapper mt-4">
        {{ $absensi->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
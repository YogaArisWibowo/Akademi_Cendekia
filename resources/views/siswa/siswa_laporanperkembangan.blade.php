@extends('layouts.app_siswa', ['title' => 'Laporan Perkembangan Siswa'])
@section('content')

<div class="nilai-card d-flex align-items-center justify-content-between mb-4">
    <div class="nilai-text">
        <span>Nilai Rata-rata</span>
    </div>
    <div class="nilai-circle">
        {{-- Tampilkan variabel $rataRata dari Controller --}}
        {{ $rataRata }}
    </div>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mapel</th>
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($laporan as $key => $item)
            <tr>
                {{-- Penomoran halaman (agar nomor berlanjut saat ganti page) --}}
                <td>{{ $laporan->firstItem() + $key }}.</td>
                
                <td>{{ $item->hari }}</td>
                
                {{-- Format Tanggal (Contoh: 05-Okt-2025) --}}
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d-M-Y') }}</td>
                
                <td>{{ $item->waktu }}</td>
                <td>{{ $item->mapel }}</td>
                
                {{-- Kolom 'laporan_perkembangan' di DB ditampilkan sebagai Catatan --}}
                <td>{{ $item->laporan_perkembangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data laporan perkembangan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($laporan->hasPages())
    <div class="pagination-wrapper mt-3">
        {{-- Tombol Sebelumnya --}}
        @if ($laporan->onFirstPage())
            <button class="btn page" disabled>Sebelumnya</button>
        @else
            <a href="{{ $laporan->previousPageUrl() }}" class="btn page">Sebelumnya</a>
        @endif

        {{-- Loop Nomor Halaman --}}
        @foreach ($laporan->getUrlRange(1, $laporan->lastPage()) as $page => $url)
            @if ($page == $laporan->currentPage())
                <button class="btn page active">{{ $page }}</button>
            @else
                <a href="{{ $url }}" class="btn page">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Tombol Selanjutnya --}}
        @if ($laporan->hasMorePages())
            <a href="{{ $laporan->nextPageUrl() }}" class="btn page">Selanjutnya</a>
        @else
            <button class="btn page" disabled>Selanjutnya</button>
        @endif
    </div>
    @endif
</div>

@endsection
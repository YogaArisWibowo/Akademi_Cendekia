@extends('layouts.app_siswa', ['title' => 'Laporan Perkembangan Siswa'])

@section('content')
    <div class="content-wrapper">
        {{-- Nama Siswa (Dari Siswa yang diampu guru login) --}}
        <h4 class="fw-bold">{{ $siswa->nama }}</h4>

        {{-- Kelas (Sesuai kolom kelas di tabel siswa) --}}
        <p class="text-muted">Kelas: {{ $siswa->kelas ?? '-' }}</p>

        {{-- Widget Nilai Rata-Rata & Tombol Tambah --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Card Nilai Rata-Rata --}}
            <div class="card shadow-sm border-0" style="min-width: 250px;">
                <div class="card-body d-flex justify-content-between align-items-center py-2 px-3">
                    <span class="fw-bold fs-5">Nilai Rata-Rata</span>

                    {{-- PERBAIKAN TAMPILAN BULAT SEMPURNA --}}
                    {{-- style ditambahkan flex-shrink:0, padding:0, dan line-height fix --}}
                    <div class="rounded-circle bg-success d-flex justify-content-center align-items-center text-white"
                        style="width: 50px; height: 50px; min-width: 50px; aspect-ratio: 1; padding: 0; font-size: 1.2rem; margin-left: 16px;">
                        {{ round($rata_rata ?? 0) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="table-container">
            <div class="table-responsive">
                <table class="table-general">
                    <thead>
                        <tr>
                            <th class="py-3 px-3">No</th>
                            <th class="py-3">Hari</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Waktu</th>
                            <th class="py-3">Mapel</th>
                            <th class="py-3">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $row)
                            <tr>
                                <td class="px-3">{{ $loop->iteration }}</td>
                                <td>{{ $row->hari }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-M-Y') }}</td>
                                <td>{{ $row->waktu }}</td>
                                <td>{{ $row->mapel }}</td>
                                <td>{{ Str::limit($row->laporan_perkembangan, 50) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada catatan perkembangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

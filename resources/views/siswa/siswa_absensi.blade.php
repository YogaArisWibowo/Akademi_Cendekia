@extends('layouts.app_siswa', ['title' => 'Absensi Siswa'])
@section('content')
    <div class="absensi-header row align-items-end mb-3">
        {{-- Filter Bulan dan Tahun --}}
        <form action="{{ route('absensi.index') }}" method="GET" class="col-md-9 row g-3">
            <div class="col-md-2">
                <label for="bulan" class="form-label mb-1">Bulan</label>
                <select name="bulan" id="bulan" class="form-select">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2">
                <label for="tahun" class="form-label mb-1">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <option value="">Pilih Tahun</option>
                    @for ($y = 2020; $y <= date('Y'); $y++)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-2 ">
                <button type="submit" class="btn btn-primary w-90 mt-4">Filter</button>
            </div>
        </form>

        {{-- Tombol Tambah --}}
        {{-- Tombol Tambah: Hanya muncul jika ada jadwal aktif --}}
        <div class="col-md-3 text-end">
            @if ($jadwalAktif)
                {{-- Jika waktunya pas, tombol muncul normal --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah +
                </button>
            @else
                {{-- Jika diluar jam, tombol disable/info --}}
                <button type="button" class="btn btn-secondary" disabled>
                    Belum Waktunya Absen
                </button>
            @endif
        </div>
    </div>
    {{-- modal tambah absensi --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- dibuat lebih lebar --}}
            {{-- Pastikan action mengarah ke 'siswa.absensi.store' --}}
            <form method="POST" action="{{ route('siswa.absensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- INPUT HARI OTOMATIS (READONLY) --}}
                                <div class="mb-3">
                                    <label class="form-label">Hari</label>
                                    <input type="text" name="hari" class="form-control"
                                        value="{{ $jadwalAktif->hari ?? '' }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    {{-- Set tanggal hari ini otomatis --}}
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}"
                                        readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Waktu</label>
                                    {{-- Set jam sekarang otomatis --}}
                                    <input type="time" name="waktu" class="form-control" value="{{ date('H:i') }}"
                                        readonly>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">
                                {{-- INPUT MAPEL OTOMATIS (READONLY) --}}
                                <div class="mb-3">
                                    <label class="form-label">Mapel</label>
                                    <input type="text" name="mapel" class="form-control"
                                        value="{{ $jadwalAktif->nama_mapel ?? '' }}" readonly>
                                </div>

                                {{-- Sisa input biarkan seperti semula --}}
                                <div class="mb-3">
                                    <label class="form-label">Kehadiran</label>
                                    <select name="kehadiran" class="form-control" required>
                                        <option value="">-- Pilih Kehadiran --</option>
                                        <option value="Hadir">Hadir</option>
                                        <option value="Ijin">Ijin</option>
                                        <option value="Sakit">Sakit</option>
                                    </select>
                                </div>
                                {{-- PERBAIKAN: Tambahkan ini agar 'id_jadwal_bimbel' terkirim ke controller --}}
                                <input type="hidden" name="id_jadwal_bimbel" value="{{ $jadwalAktif->id ?? '' }}">

                                {{-- TAMBAHAN INPUT BUKTI (Wajib ada karena Controller minta) --}}
                                <div class="mb-3">
                                    <label class="form-label">Bukti Foto (Opsional)</label>
                                    <input type="file" name="bukti" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="2" placeholder="Tambahkan catatan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
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
                    <th>Bukti Kehadiran</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                        <td>{{ $item->waktu }}</td>
                        <td>{{ $item->mapel ?? '-' }}</td>
                        <td>
                            @if ($item->kehadiran == 'Hadir')
                                <span class="badge badge-hadir">Hadir</span>
                            @elseif ($item->kehadiran == 'Ijin')
                                <span class="badge badge-izin">Ijin</span>
                            @else
                                <span class="badge badge-sakit">Sakit</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            <button class="btn page">Sebelumnya</button>
            <button class="btn page active">1</button>
            <button class="btn page">2</button>
            <button class="btn page">3</button>
            <button class="btn page active">Selanjutnya</button>
        </div>

    </div>
@endsection

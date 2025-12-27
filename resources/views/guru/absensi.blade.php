@extends('layouts.app_guru', ['title' => 'Absensi Guru'])
@section('content')
    <div class="absensi-header row align-items-end mb-3">

        {{-- FORM FILTER (Menggunakan Grid System col-md-9) --}}
        <form method="GET" action="{{ route('absensi_guru') }}" class="col-md-9 row g-3">

            {{-- Filter Bulan --}}
            <div class="col-md-3">
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

            {{-- Filter Tahun --}}
            <div class="col-md-3">
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

            {{-- Tombol Filter --}}
            <div class="col-md-2">
                {{-- mt-4 diberikan agar tombol sejajar dengan input (karena input ada label di atasnya) --}}
                <button type="submit" class="btn btn-primary w-90 mt-4">Filter</button>
            </div>
        </form>

        {{-- TOMBOL TAMBAH --}}
        <div class="col-md-3 text-end">
            @if ($jadwalAktif)
                {{-- Jika Jadwal Ada (Masuk Range Jam), Tombol Muncul --}}
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    Tambah +
                </button>
            @else
                {{-- Jika Diluar Jam, Tombol Disabled / Info --}}
                <button type="button" class="btn btn-secondary" disabled title="Menu hanya aktif saat jam mengajar">
                    Belum Waktunya Absen
                </button>
            @endif
        </div>

    </div>


    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- dibuat lebih lebar --}}
            <form method="POST" action="{{ route('absensi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Hidden Input untuk ID Jadwal Bimbel (PENTING BUAT STORE) --}}
                        <input type="hidden" name="id_jadwal_bimbel" value="{{ $jadwalAktif->id ?? '' }}">

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-6">

                                {{-- Hari: Otomatis Terisi & Terkunci Tampilannya --}}
                                <div class="mb-3">
                                    <label class="form-label">Hari</label>
                                    {{-- Kita gunakan style pointer-events:none dan bg abu-abu agar terlihat mati --}}
                                    <select name="hari" class="form-control" required
                                        style="pointer-events: none; background-color: #e9ecef;">
                                        <option value="{{ $jadwalAktif->hari ?? '' }}" selected>
                                            {{ $jadwalAktif->hari ?? '-' }}</option>
                                    </select>
                                </div>

                                {{-- Tanggal: Otomatis Hari Ini --}}
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}"
                                        readonly style="background-color: #e9ecef;">
                                </div>

                                {{-- Waktu: Otomatis Jam Sekarang --}}
                                <div class="mb-3">
                                    <label class="form-label">Waktu</label>
                                    <input type="time" name="waktu" class="form-control" value="{{ date('H:i') }}"
                                        readonly style="background-color: #e9ecef;">
                                </div>

                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="col-md-6">

                                {{-- Mapel: Otomatis ambil dari Jadwal --}}
                                <div class="mb-3">
                                    <label class="form-label">Mapel</label>
                                    <input type="text" name="mapel" class="form-control"
                                        value="{{ $jadwalAktif->mapel->nama_mapel ?? ($jadwalAktif->nama_mapel ?? '') }}"
                                        readonly style="background-color: #e9ecef;">
                                </div>

                                {{-- Bukti Kehadiran --}}
                                <div class="mb-3">
                                    <label class="form-label">Bukti Kehadiran (jpg/jpeg)</label>
                                    <input type="file" name="bukti" class="form-control" accept=".jpg,.jpeg" required>
                                </div>

                                {{-- Catatan --}}
                                <div class="mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan..."></textarea>
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
                    <th>Catatan</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                        <td>{{ $item->waktu }}</td>
                        <td>{{ $item->mapel ?? '-' }}</td>
                        <td>
                            <img src="{{ asset('bukti_absensi/' . $item->bukti_foto) }}" width="60">
                        </td>
                        <td>{{ $item->laporan_kegiatan }}</td>
                    </tr>
                @endforeach
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

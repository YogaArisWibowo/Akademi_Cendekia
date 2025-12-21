@extends('layouts.app_guru', ['title' => 'Detail Laporan Perkembangan Siswa'])

@section('content')
    <div class="content-wrapper">

        {{-- Header & Tombol Kembali --}}
        <div class="mb-3">
            <a href="{{ route('laporan_perkembangan_siswa') }}" class="btn btn-secondary btn-sm">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>

        <h4 class="fw-bold">{{ $siswa->nama }}</h4>
        {{-- Saya asumsikan kolom jenjang/kelas ada di tabel siswa --}}
        {{-- Jika error undefined, hapus bagian {{ $siswa->jenjang }} --}}
        <p class="text-muted">Kelas: {{ $siswa->kelas ?? '-' }}</p>

        {{-- Widget Nilai Rata-Rata & Tombol Tambah --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Card Nilai Rata-Rata (Sesuai Desain) --}}
            <div class="card shadow-sm border-0" style="min-width: 250px;">
                <div class="card-body d-flex justify-content-between align-items-center py-2 px-3">
                    <span class="fw-bold fs-5">Nilai Rata-Rata</span>
                    <span class="badge rounded-circle bg-success d-flex justify-content-center align-items-center"
                        style="width: 45px; height: 45px; font-size: 1.2rem; margin-left: 16px;">
                        {{ round($rata_rata ?? 0) }}
                    </span>
                </div>
            </div>

            {{-- Tombol Tambah (Kuning) --}}
            <button type="button" class="btn btn-primary text-white fw-bold px-4 py-2" data-bs-toggle="modal"
                data-bs-target="#tambahModal">
                Tambah +
            </button>
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
                            <th class="py-3 text-center">Aksi</th>
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
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $row->id }}">
                                        <i class="ri-edit-box-line"></i>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada catatan perkembangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @foreach ($laporan as $row)
                    <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('laporan_perkembangan_siswa.update', $row->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="editModalLabel{{ $row->id }}">Edit Catatan
                                            Perkembangan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            {{-- Hari --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Hari</label>
                                                <select name="hari" class="form-select" required>
                                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                                        <option value="{{ $hari }}"
                                                            {{ $row->hari == $hari ? 'selected' : '' }}>
                                                            {{ $hari }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- Tanggal --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control"
                                                    value="{{ $row->tanggal }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            {{-- Waktu --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Waktu</label>
                                                <input type="time" name="waktu" class="form-control"
                                                    value="{{ $row->waktu }}" required>
                                            </div>
                                            {{-- Mapel --}}
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Mapel</label>
                                                <input type="text" name="mapel" class="form-control"
                                                    value="{{ $row->mapel }}" required>
                                            </div>
                                        </div>

                                        {{-- Catatan --}}
                                        <div class="mb-3">
                                            <label class="form-label">Catatan Perkembangan</label>
                                            <textarea name="catatan" class="form-control" rows="4" required>{{ $row->laporan_perkembangan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pagination dihapus sesuai permintaan --}}

        {{-- Modal Tambah --}}
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('laporan_perkembangan_siswa.tambah') }}">
                    @csrf
                    <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="tambahModalLabel">Tambah Catatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hari</label>
                                    <select name="hari" class="form-select" required>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu</label>
                                    <input type="time" name="waktu" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mapel</label>
                                    <input type="text" name="mapel" class="form-control"
                                        placeholder="Contoh: Matematika" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan Perkembangan</label>
                                <textarea name="catatan" class="form-control" rows="4" placeholder="Tulis catatan perkembangan siswa..."
                                    required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

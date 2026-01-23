@extends('layouts.app_guru', ['title' => 'Detail Tugas Siswa'])

@section('content')
    <div class="content-wrapper">

        {{-- Header Navigasi --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('tugas_siswa') }}" class="btn btn-warning">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah +
            </button>
        </div>

        {{-- Nama Siswa --}}
        <h4 class="fw-bold mb-3">{{ $siswa->nama }}</h4>
        <p class="text-muted mb-3">Kelas: {{ $siswa->kelas }} / {{ $siswa->jenjang }}</p>

        {{-- Daftar Tugas (UPDATED: Menampilkan Nama Mapel & Penugasan) --}}
        <div class="row">
            @forelse($tugas as $t)
                <div class="col-md-5 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center gap-2">

                            <div class="icon bg-warning text-white rounded-circle p-3">
                                <i class="ri-clipboard-line fs-3"></i>
                            </div>
                            <div>
                                <a href="{{ route('detail_tugas_persiswa', ['id' => $siswa->id, 'tugas_id' => $t->id]) }}"
                                    class="text-decoration-none text-dark">
                                    {{-- Judul: Nama Mapel --}}
                                    <h6 class="mb-1 fw-bold">{{ $t->nama_mapel }}</h6>
                                    {{-- Deskripsi: Penugasan --}}
                                    <p class="mb-0 text-dark small">{{ $t->penugasan }}</p>
                                    <small class="text-muted">
                                        Deadline: {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                        ({{ $t->waktu_selesai ?? '-' }})
                                    </small>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada tugas.</p>
            @endforelse
        </div>

        {{-- Modal Tambah (UPDATED: Tambah Input Waktu) --}}
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('tugas_siswa.simpan') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Tugas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            {{-- Input Mapel --}}
                            <div class="mb-3">
                                <label for="id_mapel" class="form-label">Mata Pelajaran</label>
                                <select name="id_mapel" id="id_mapel" class="form-control" required>
                                    <option value="">-- Pilih Mapel --</option>

                                    {{-- LOOPING DARI DATABASE (JANGAN MANUAL) --}}
                                    @foreach ($daftar_mapel as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Input Judul Penugasan --}}
                            <div class="mb-3">
                                <label for="penugasan" class="form-label">Detail Penugasan (Deskripsi)</label>
                                <textarea class="form-control" id="penugasan" name="penugasan" rows="2" required
                                    placeholder="Contoh: Kerjakan Halaman 50"></textarea>
                            </div>

                            {{-- Input Tanggal --}}
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>

                            {{-- Input Waktu --}}
                            <div class="row">
                                {{-- Waktu Mulai (Opsional: Bisa di-hidden atau ditampilkan) --}}
                                {{-- Kita hidden saja biar guru tidak repot, diasumsikan mulai saat tugas dibuat --}}

                                <div class="col-12 mb-3">
                                    <label for="waktu_selesai" class="form-label">Batas Waktu Pengerjaan (Jam)</label>
                                    <input type="time" class="form-control" name="waktu_selesai" required>
                                </div>
                            </div>

                            {{-- Input Upload File --}}
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File Soal (Opsional)</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="form-text text-muted small">Format: PDF/Gambar. Max 2MB.</div>
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

    </div>
@endsection

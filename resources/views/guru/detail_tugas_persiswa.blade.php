@extends('layouts.app_guru', ['title' => 'Detail Tugas'])

@section('content')
    <div class="content-wrapper">

        {{-- Header Navigasi & Judul (Sesuai Desain Bagian Atas) --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Tombol Kembali (Desain Grey/Silver) --}}
            <a href="{{ route('detail_tugas_siswa', ['id' => $siswa->id]) }}" class="btn btn-warning text-black"
                >
                <i class="ri-arrow-left-line"></i> Kembali
            </a>

            {{-- Tombol Ubah (Desain Biru di Kanan Atas) --}}
            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editModal">
                Ubah <i class="ri-edit-box-line ms-1"></i>
            </button>
        </div>

        {{-- Konten Utama (Single Card Layout) --}}
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="row">

                    {{-- Kiri: Detail Tugas & Deskripsi --}}
                    <div class="col-lg-8 pe-lg-5">
                        <div class="d-flex align-items-start mb-3">
                            {{-- Icon Bulat Orange --}}
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3"
                                style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="ri-file-list-3-fill text-white fs-4"></i>
                            </div>

                            {{-- Judul & Tanggal --}}
                            <div>
                                <h5 class="fw-bold mb-1">{{ $tugas->nama_mapel }}</h5>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($tugas->tanggal)->format('d M Y') }}
                                    Deadline:
                                    ({{ $tugas->waktu_selesai ?? '-' }})</small>
                            </div>
                        </div>

                        <hr class="my-4 text-muted" style="opacity: 0.2;">

                        {{-- Deskripsi Tugas --}}
                        <div class="mb-4">
                            <label class="text-muted mb-2" style="font-size: 0.9rem;">Detail Tugas :</label>
                            <p class="text-dark">
                                {{ $tugas->penugasan ?? '......' }}
                            </p>
                        </div>
                    </div>

                    {{-- Kanan: Panel Jawaban & Nilai --}}
                    <div class="col-lg-4 border-start border-light">
                        <div class="card border border-light shadow-sm"
                            style="border-radius: 12px; background-color: #fff;">
                            <div class="card-body">
                                {{-- Header Jawaban & Nilai --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Jawaban</h6>
                                    <span class="fw-bold {{ $tugas->nilai_tugas ? 'text-success' : 'text-muted' }}"
                                        style="font-size: 1.1rem;">
                                        {{ $tugas->nilai_tugas ?? '...' }} <span class="text-muted"
                                            style="font-size: 0.9rem;">/ 100</span>
                                    </span>
                                </div>

                                {{-- File Preview Container --}}
                                <div class="border rounded p-3 mb-2" style="background-color: #f8f9fa;">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-file-pdf-line text-danger me-2 fs-5"></i>
                                        @if ($tugas->file)
                                            <a href="{{ asset('storage/tugas/' . $tugas->file) }}" target="_blank"
                                                class="text-dark text-decoration-underline fw-bold"
                                                style="font-size: 0.9rem;">
                                                Tugas.pdf
                                            </a>
                                        @else
                                            <span class="text-muted" style="font-size: 0.9rem;">Tidak ada file</span>
                                        @endif
                                    </div>

                                    {{-- Kotak Abu-abu (Placeholder Preview) --}}
                                    <div class="rounded w-100" style="height: 120px; background-color: #d1d5db;"></div>
                                </div>

                                {{-- Jawaban Teks (Opsional jika ingin ditampilkan di bawah box) --}}
                                <div class="mt-3">
                                    <small class="text-muted d-block">Catatan Siswa:</small>
                                    <p class="small mb-0">{{ $tugas->jawaban_siswa ?? '-' }}</p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal Edit (Tetap Sama, hanya penyesuaian styling sedikit) --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('tugas_siswa.update', $tugas->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="editModalLabel">Edit Tugas & Nilai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            {{-- Form Input --}}
                            <div class="mb-3">
                                <label class="form-label">Judul Tugas (Mapel)</label>
                                {{-- PERBAIKAN: Ganti name="penugasan" jadi name="nama_mapel" --}}
                                <input type="text" name="nama_mapel" class="form-control"
                                    value="{{ $tugas->nama_mapel }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail Tugas</label>
                                {{-- Ini tetap name="penugasan" --}}
                                <input type="text" name="penugasan" class="form-control" value="{{ $tugas->penugasan }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                {{-- GANTI value-nya mengambil dari kolom 'tanggal' --}}
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($tugas->tanggal)->format('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deadline (Waktu Selesai)</label>
                                <input type="time" name="waktu_selesai" class="form-control"
                                    value="{{ $tugas->waktu_selesai }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jawaban Siswa (Teks)</label>
                                <textarea name="jawaban_siswa" class="form-control" rows="3">{{ $tugas->jawaban_siswa }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nilai (0-100)</label>
                                    <input type="number" name="nilai_tugas" class="form-control"
                                        value="{{ $tugas->nilai_tugas }}" min="0" max="100">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Update File (PDF)</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@extends('layouts.app_guru', ['title' => 'Detail Tugas'])

@section('content')
    <div class="content-wrapper">

        {{-- Header Navigasi & Judul --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('detail_tugas_siswa', ['id' => $siswa->id]) }}" class="btn btn-warning text-black">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>

            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editModal">
                Ubah <i class="ri-edit-box-line ms-1"></i>
            </button>
        </div>

        {{-- Konten Utama --}}
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="row">

                    {{-- Kiri: Detail Tugas & Deskripsi --}}
                    <div class="col-lg-8 pe-lg-5">
                        <div class="d-flex align-items-start mb-3">
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3"
                                style="width: 50px; height: 50px; min-width: 50px;">
                                <i class="ri-file-list-3-fill text-white fs-4"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1">{{ $tugas->nama_mapel }}</h5>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($tugas->tanggal)->format('d M Y') }}
                                    Deadline: ({{ $tugas->waktu_selesai ?? '-' }})</small>
                            </div>
                        </div>

                        <hr class="my-4 text-muted" style="opacity: 0.2;">

                        {{-- Deskripsi Tugas --}}
                        <div class="mb-4">
                            <label class="text-muted mb-2" style="font-size: 0.9rem;">Detail Tugas :</label>
                            <p class="text-dark">
                                {{ $tugas->penugasan ?? '......' }}
                            </p>

                            {{-- TOMBOL DOWNLOAD FILE SOAL (GURU) --}}
                            @if ($tugas->file)
                                <div class="mt-4">
                                    <label class="text-muted mb-2 d-block" style="font-size: 0.9rem;">File Soal :</label>
                                    {{-- Pastikan path sesuai Controller: uploads/tugas_guru --}}
                                    <a href="{{ asset('uploads/tugas_guru/' . $tugas->file) }}"
                                        class="btn btn-outline-primary" download>
                                        <i class="ri-download-line me-2"></i> Download File Tugas
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kanan: Panel Jawaban Siswa --}}
                    <div class="col-lg-4 border-start border-light">
                        <div class="card border border-light shadow-sm"
                            style="border-radius: 12px; background-color: #fff;">
                            <div class="card-body">

                                {{-- Header Jawaban & Nilai --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Jawaban Siswa</h6>
                                    <span class="fw-bold {{ $tugas->nilai_tugas ? 'text-success' : 'text-muted' }}"
                                        style="font-size: 1.1rem;">
                                        {{ $tugas->nilai_tugas ?? '...' }} <span class="text-muted"
                                            style="font-size: 0.9rem;">/ 100</span>
                                    </span>
                                </div>

                                {{-- File Preview Container (JAWABAN SISWA) --}}
                                <div class="border rounded p-3 mb-2" style="background-color: #f8f9fa;">

                                    @if ($tugas->jawaban_siswa)
                                        {{-- Jika Siswa Sudah Upload --}}
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="ri-file-pdf-line text-danger me-2 fs-4"></i>
                                            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                    {{ $tugas->jawaban_siswa }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            {{-- Tombol Buka File (New Tab) --}}
                                            <a href="{{ asset('uploads/jawaban/' . $tugas->jawaban_siswa) }}"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ri-eye-line me-1"></i> Buka File
                                            </a>

                                            {{-- Tombol Download --}}
                                            <a href="{{ asset('uploads/jawaban/' . $tugas->jawaban_siswa) }}" download
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="ri-download-cloud-line me-1"></i> Download
                                            </a>
                                        </div>
                                    @else
                                        {{-- Jika Belum Ada Jawaban --}}
                                        <div class="text-center py-4">
                                            <i class="ri-close-circle-line text-muted fs-1 mb-2"></i>
                                            <p class="text-muted small mb-0">Siswa belum mengunggah jawaban.</p>
                                        </div>
                                    @endif

                                </div>
                                {{-- Bagian Catatan/Jawaban Teks SUDAH DIHAPUS --}}

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
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
                                <input type="text" name="nama_mapel" class="form-control"
                                    value="{{ $tugas->nama_mapel }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail Tugas</label>
                                <input type="text" name="penugasan" class="form-control" value="{{ $tugas->penugasan }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($tugas->tanggal)->format('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deadline (Waktu Selesai)</label>
                                <input type="time" name="waktu_selesai" class="form-control"
                                    value="{{ $tugas->waktu_selesai }}" required>
                            </div>

                            {{-- BAGIAN INPUT JAWABAN SISWA SUDAH DIHAPUS --}}

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nilai (0-100)</label>
                                    <input type="number" name="nilai_tugas" class="form-control"
                                        value="{{ $tugas->nilai_tugas }}" min="0" max="100">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Update File Soal (Guru)</label>
                                    <input type="file" name="file" class="form-control">
                                    <small class="text-muted">Biarkan kosong jika tidak diganti.</small>
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

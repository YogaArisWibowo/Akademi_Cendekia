@extends('layouts.app_siswa', ['title' => 'Tugas Siswa'])

@section('content')
    {{-- ALERT Notifikasi Sukses/Error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('siswa.siswa_daftartugas') }}" class="back-btn">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>

    <div class="tugas-siswa-card">

        <div class="tugas-info">
            <div class="tugas-header">
                <div class="icon-wrapper">
                    <i class="ri-todo-fill"></i>
                </div>

                <div>
                    <h4 class="tugas-title">{{ $tugas->penugasan }}</h4>
                    <span class="tanggal">
                        {{ \Carbon\Carbon::parse($tugas->tanggal)->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>

            <hr class="detail-line">

            <span class="label">Detail Tugas :</span>
            <p class="detail-text" style="white-space: pre-line;">
                {{ $tugas->penugasan }}
            </p>

            {{-- ========================================== --}}
            {{-- TAMBAHAN: DOWNLOAD FILE GURU (SOAL)        --}}
            {{-- ========================================== --}}
            @if ($tugas->file)
                <div class="mt-3">
                    <label class="label" style="font-size: 14px; display:block; margin-bottom:5px;">File Lampiran
                        Soal:</label>

                    {{-- Tombol Download --}}
                    {{-- Pastikan folder 'uploads/tugas_guru' sesuai dengan tempat Guru mengupload --}}
                    <a href="{{ asset('uploads/tugas_guru/' . $tugas->file) }}" class="btn btn-outline-primary btn-sm"
                        download>
                        <i class="ri-download-line"></i> Download File Tugas
                    </a>
                </div>
            @endif
            {{-- ========================================== --}}

        </div>

        <div class="jawaban-container mt-4">
            {{-- ... (Bagian Upload Jawaban Siswa biarkan tetap sama) ... --}}

            <div class="jawaban-header">
                <span>Jawaban</span>
                <span class="nilai">
                    {{ $tugas->nilai_tugas ? $tugas->nilai_tugas : '...' }} / 100
                </span>
            </div>

            <div class="jawaban-list">
                @if ($tugas->jawaban_siswa)
                    <div class="jawaban-item">
                        <i class="ri-file-pdf-line file-icon"></i>
                        <div>
                            <span class="file-name" style="display: block;">{{ $tugas->jawaban_siswa }}</span>
                            <a href="{{ asset('uploads/jawaban/' . $tugas->jawaban_siswa) }}" target="_blank"
                                style="font-size: 12px; color: #1976d2;">
                                Lihat File
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-center text-muted mt-3" style="font-size: 14px;">Belum ada file yang diunggah.</p>
                @endif
            </div>

            <button type="button" class="btn-unggah-tugas w-100 mt-3" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="ri-add-line"></i> Unggah Tugas
            </button>

        </div>
    </div>

    {{-- ... (Modal Upload Tetap Sama) ... --}}
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        {{-- ... Isi Modal tetap sama ... --}}
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Unggah Jawaban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('siswa.tugas.upload', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_jawaban" class="form-label">Pilih File PDF</label>
                            <input class="form-control" type="file" id="file_jawaban" name="file_jawaban" accept=".pdf"
                                required>
                            <div class="form-text">Format file harus PDF. Maksimal ukuran 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

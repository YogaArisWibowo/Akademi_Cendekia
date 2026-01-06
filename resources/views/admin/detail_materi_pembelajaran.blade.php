@extends('layouts.app_admin', ['title' => 'Materi Pembelajaran'])

@section('content')
<style>
    .back { background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px; color: white; font-weight: 500; font-size: large; cursor: pointer; align-items: center; justify-content: center; margin-bottom: 20px; }
    .back i { padding-right: 5px; }
    .ubah { margin-bottom: 5px; display: flex; justify-content: flex-end; color: white; border: none; border-radius: 6px; background-color: #1876ff; font-weight: 600 !important; align-items: center; width: 102px; height: 40px; }
    .ubah i { color: white; font-size: 20px !important; padding-left: 10px; padding-right: 5px; line-height: 0; vertical-align: middle; display: inline-block; }
    .data { font-weight: 600 !important; font-size: 30px; padding-left: 15px; }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> Periksa inputan Anda:
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin_Materi_Pembelajaran') }}">
            <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <p class="data">{{ $materi->nama_materi }}</p>
        <button class="ubah text-center" data-bs-toggle="modal" data-bs-target="#modalUbahMateri">
            Ubah <i class="bi bi-pencil-square"></i>
        </button>
    </div>

    <div class="materi-detail-card">
        <p><strong>Materi :</strong></p>
        <div class="mb-3 ps-3">
            {{-- Link download mengambil dari file_materi --}}
            <a href="{{ asset('materi/' . $materi->file_materi) }}" target="_blank" class="btn-download" style="background-color: #28a745; color: white; padding: 8px 20px; text-decoration: none; border-radius: 8px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s;">
                <i class="ri-download-line"></i> Unduh File
            </a>
        </div>

        <p><strong>Siswa Penerima :</strong></p>
        <div class="mb-3 ps-3">
             <span class="badge bg-secondary" style="font-size: 14px; font-weight: normal;">
                <i class="bi bi-person-fill"></i> {{ $materi->siswa->nama ?? 'Siswa tidak ditemukan' }}
            </span>
        </div>

        <p><strong>Ringkasan :</strong></p>
        <div class="ps-3 text-muted">
            {{-- [PERBAIKAN] Cek $materi->materi bukan ringkasan --}}
            @if($materi->materi)
                {!! nl2br(e($materi->materi)) !!}
            @else
                <p><em>Belum ada ringkasan untuk materi ini.</em></p>
            @endif
        </div>
    </div>
</div>

{{-- MODAL UBAH MATERI --}}
<div class="modal fade" id="modalUbahMateri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin_Materi_Pembelajaran.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Materi</label>
                        <input type="text" name="nama_materi" class="form-control" value="{{ $materi->nama_materi }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="id_mapel" class="form-select" required>
                            @foreach($dataMapel as $m)
                                <option value="{{ $m->id }}" {{ $materi->id_mapel == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Siswa Penerima</label>
                        <select name="id_siswa" class="form-select" required>
                            @foreach($dataSiswa as $siswa)
                                <option value="{{ $siswa->id }}" {{ $materi->id_siswa == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        {{-- Isi textarea diambil dari kolom 'materi' --}}
                        <textarea name="ringkasan" class="form-control" rows="5">{{ $materi->materi }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Materi (Kosongkan jika tidak diubah)</label>
                        <input type="file" name="file_materi" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png">
                        <small class="text-muted">File saat ini: {{ $materi->file_materi }}</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #1876ff; border:none;">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
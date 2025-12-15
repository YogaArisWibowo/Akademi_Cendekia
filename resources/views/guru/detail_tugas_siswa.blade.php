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
    <h4 class="fw-bold mb-3">Hafidz</h4>

    {{-- Daftar Tugas --}}
    <div class="row">
        {{-- Contoh kartu tugas --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon bg-warning text-white rounded-circle p-3">
                        <i class="ri-clipboard-line fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Tugas Menghitung Segitiga</h6>
                        <small class="text-muted">11 Nov</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tambahkan loop data tugas di sini --}}
        {{-- @foreach ($tugas as $item)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon bg-warning text-white rounded-circle p-3">
                            <i class="ri-clipboard-line fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $item->judul }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}

    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="#">
                {{-- @csrf --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Tugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
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
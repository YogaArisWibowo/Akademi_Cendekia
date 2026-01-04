@extends('layouts.app_admin', ['title' => 'Gaji Guru']) 

@section('content')

<style>
    .back { background-color: #c7c7c7; border-radius: 10px; border: none; width: 110px; height: 35px; color: white; font-weight: 500; font-size: large; cursor: pointer; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; text-decoration: none; }
    .back i { padding-right: 5px; }
    .tambah { margin-bottom: 5px; display: flex; justify-content: center; color: white; border: none; border-radius: 6px; background-color: #ffd700; font-weight: 500 !important; align-items: center; width: 102px; height: 30px; cursor: pointer; }
    .tambah i { color: white; font-size: 25px !important; padding-left: 5px; line-height: 0; vertical-align: middle; }
    .data { font-weight: 600 !important; font-size: 30px; padding-left: 15px; }
    .table-container { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .table-general { width: 100%; border-collapse: collapse; }
    .table-general th, .table-general td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
    .status-aktif { background-color: #e8f5e9 !important; color: #2e7d32 !important; font-weight: bold; padding: 5px 10px; border-radius: 10px; font-size: 12px; }
    .status-non-aktif { background-color: #ffebee !important; color: #c62828 !important; font-weight: bold; padding: 5px 10px; border-radius: 10px; font-size: 12px; }
    .btn-edit { background-color: #3182ce; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 12px; }
    .pagination-wrapper { display: flex; justify-content: center; margin-top: 20px; gap: 5px; }
    .btn.page { border: 1px solid #e2e8f0; background: white; padding: 6px 14px; border-radius: 8px; cursor: pointer; }
    .btn.page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; border-color: #3182ce; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Pencatatan_Gaji_Guru') }}" class="back">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-2">
    <p class="data">{{ $guru->nama }}</p>
    <button class="tambah" data-bs-toggle="modal" data-bs-target="#modalTambahGaji">
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Guru Mapel</th>
                <th>Rekening</th>
                <th>Gaji Perjam</th>
                <th>Jumlah Absensi</th>
                <th>Total Gaji</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->mapel ?? '-' }}</td>
                <td>{{ $guru->rekening ?? '-' }}</td>
                <td>Rp {{ number_format($gaji_guru->gaji_per_jam ?? 0, 0, ',', '.') }}</td>
                <td>{{ $jumlah_absensi ?? 0 }} Kehadiran</td>
                <td><strong>Rp {{ number_format($totalGaji, 0, ',', '.') }}</strong></td>
                <td>
                    <span class="{{ strtolower($gaji_guru->kehadiran ?? '') == 'sudah terbayar' ? 'status-aktif' : 'status-non-aktif' }}">
                        {{ $gaji_guru->kehadiran ?? 'Belum Ada Data' }}
                    </span>
                </td>
                <td>
                    @if($gaji_guru)
                    <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditGaji">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    @else
                    -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <div class="pagination-wrapper">
        <button class="btn page" disabled>Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page" disabled>Selanjutnya</button>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahGaji" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin_detail_pencatatan_gaji_guru.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_guru" value="{{ $guru->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Total Kehadiran</label>
                        <input type="text" class="form-control" value="{{ $jumlah_absensi }} Pertemuan" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gaji Perjam (Rp)</label>
                        <input type="number" name="gaji_per_jam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="kehadiran" class="form-select">
                            <option value="Belum Terbayar">Belum Terbayar</option>
                            <option value="Sudah Terbayar">Sudah Terbayar</option>
                            <option value="Ijin">Ijin</option>
                        </select>
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

{{-- MODAL EDIT (Data Terakhir) --}}
@if($gaji_guru)
<div class="modal fade" id="modalEditGaji" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin_detail_pencatatan_gaji_guru.update', $gaji_guru->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Gaji Terakhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Gaji Perjam (Rp)</label>
                        <input type="number" name="gaji_per_jam" class="form-control" value="{{ $gaji_guru->gaji_per_jam }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="kehadiran" class="form-select">
                            <option value="Belum Terbayar" {{ $gaji_guru->kehadiran == 'Belum Terbayar' ? 'selected' : '' }}>Belum Terbayar</option>
                            <option value="Sudah Terbayar" {{ $gaji_guru->kehadiran == 'Sudah Terbayar' ? 'selected' : '' }}>Sudah Terbayar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@endsection
@extends('layouts.app_admin', ['title' => 'Gaji Guru']) @section('content')

<style>
    .back {
        background-color: #c7c7c7;
        border-radius: 10px;
        border: none;
        width: 110px;
        height: 35px;
        color: white;
        font-weight: 500;
        font-size: large;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .back i {
        padding-right: 5px;
    }

    .tambah {
        margin-bottom: 5px;
        display: flex;
        justify-content: flex-end;
        color: white;
        border: none;
        border-radius: 6px;
        background-color: #ffd700;
        font-weight: 500 !important;
        align-items: center;
        width: 102px;
        height: 30px;
    }
    .tambah i {
        color: white;
        font-size: 25px !important;
        padding-left: 5px;
        line-height: 0;
        vertical-align: middle;
        display: inline-block;
    }
    .tambah-siswa {
        margin-bottom: 5px;
        display: flex;
        justify-content: flex-end;
        color: white;
        border: none;
        border-radius: 6px;
        background-color: #ffd700;
        font-weight: 500 !important;
        align-items: center;
        width: 102px;
        height: 30px;
        margin-top: 20px;
    }
    .tambah-siswa i {
        color: white;
        font-size: 25px !important;
        padding-left: 5px;
        line-height: 0;
        vertical-align: middle;
        display: inline-block;
    }
    .data {
        font-weight: 600 !important;
        font-size: 30px;
        padding-left: 15px;
    }

    .custom-status-dropdown {
        border-radius: 15px !important;
        padding: 5px 15px;
        border-color: #3f51b5;
        transition: all 0.3s; /* Efek transisi untuk perubahan warna */
    }

    .status-aktif {
        background-color: #e8f5e9 !important;
        color: #2e7d32 !important;
        font-weight: bold;
    }

    .status-non-aktif {
        background-color: #ffebee !important;
        color: #c62828 !important;
        font-weight: bold;
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Pencatatan_Gaji_Guru') }}">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>
<div class="d-flex justify-content-between align-items-center mb-2">
    <p class="data">Ira Sulistiya</p>

    <button
        class="tambah text-center"
        data-bs-toggle="modal"
        data-bs-target="#modalTambahJadwal"
    >
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Guru Jenjang</th>
                <th>Rekening</th>
                <th>Gaji Per Jam</th>
                <th>Absensi</th>
                <th>Total Gaji</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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

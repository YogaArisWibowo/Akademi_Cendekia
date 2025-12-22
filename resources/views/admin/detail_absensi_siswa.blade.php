@extends('layouts.app_admin', ['title' => 'Absensi Siswa']) @section('content')

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

    /* TAMBAHAN CSS UNTUK NAMA, FILTER, DAN UNDUH AGAR SEJAJAR */
    .header-custom-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
        margin-bottom: 30px;
    }
    .profile-info h3 {
        margin: 0;
        font-weight: 700;
        color: #1f2937;
    }
    .left-controls {
        display: flex;
        align-items: flex-end;
        gap: 50px; /* Jarak antara Nama dan Filter agar tidak menempel */
    }
    .controls-group {
        display: flex;
        gap: 10px;
    }
    .filter-select {
        height: 35px;
        width: 120px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 0 10px;
        font-size: 13px;
        background-color: white;
        border-color: transparent !important;
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.203);
        cursor: pointer;
    }
    .btn-download-green {
        background-color: #00cb0a;
        color: white;
        border: none;
        border-radius: 8px;
        height: 35px;
        padding: 0 15px;
        font-weight: 600;
        cursor: pointer;
    }
    .pagination-wrapper {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-page {
        border: none;
        background: transparent;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        color: #4a5568;
        cursor: pointer;
    }

    .btn-page.active {
        background-color: #ebf4ff;
        color: #3182ce;
        font-weight: 600;
    }

    .btn-page.next-btn {
        background-color: #c3dafe;
        color: #1a365d;
        font-weight: 500;
        border-radius: 8px;
    }

    .btn-page:disabled {
        cursor: default;
        background-color: #f7fafc;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('Absensi') }}">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

<div class="header-custom-wrapper">
    <div class="left-controls">
        <div class="profile-info">
            <h3>Ira Sulistya</h3>
        </div>

        <div class="controls-group">
            <select class="filter-select">
                <option selected disabled>Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>

            <select class="filter-select">
                <option selected disabled>Tahun</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
        </div>
    </div>
    <button class="btn-download-green">Unduh</button>
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
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Senin</td>
                <td>01-04-2025</td>
                <td>14.00</td>
                <td>Biologi</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="pagination-wrapper">
        <button class="btn-page text-muted" disabled>Sebelumnya</button>
        <button class="btn-page active">1</button>
        <button class="btn-page">2</button>
        <button class="btn-page">3</button>
        <button class="btn-page next-btn">Selanjutnya</button>
    </div>
</div>
@endsection

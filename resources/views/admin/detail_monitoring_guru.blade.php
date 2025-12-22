@extends('layouts.app_admin', ['title' => 'Monitoring Guru']) @section('content')

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

    .profile-info h3 {
        margin: 0;
        font-weight: 700;
        color: #1f2937;
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
    .badge-number {
        background-color: #2b6cb0; /* Biru sesuai gambar */
        color: white;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(43, 108, 176, 0.3);
    }
    .custom-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
        width: 60%;
        height: 80px;
    }
    .card-body-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .name {
        margin: 0;
        font-weight: 700;
        color: #1a202c;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Monitoring_Guru') }}">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>
<div class="profile-info mb-4">
    <h3>Ira Sulistya</h3>
</div>
<div class="custom-card ">
    <div class="card-body-content">
        <div class="info">
            <h5 class="name">Total Absensi</h5>
        </div>
        <div class="badge-number">1</div>
    </div>
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
                <th>Catatan</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Senin</td>
                <td>01-04-2025</td>
                <td>14.00</td>
                <td>Biologi</td>
                <td><a href="#"><u>Lihat</u></a></td>
                <td> Memberi Catatan </td>
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

@extends('layouts.app_admin', ['title' => 'Pembayaran Bimbel'])
@section('content')

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
        margin-top: 20px;
        margin-bottom: 30px;
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
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Pembayaran_Siswa') }}">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas/Jenjang</th>
                <th>No hp</th>
                <th>Nominal</th>
                <th>Bukti Pembayaran</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>01-04-2025</td>
                <td>Yoga</td>
                <td>SMP</td>
                <td>0878 Kapan Kita jalan</td>
                <td>5000</td>
                <td>
                    <a href="#"><u>Lihat</u></a>
                </td>
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

@extends('layouts.app_admin', ['title' => 'Laporan Perkembangan Siswa'])
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

    .profile-info h3 {
        margin: 0;
        font-weight: 700;
        color: #1f2937;
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
    /* Mengatur kontainer utama agar kartu dan nama tidak bertumpuk */
    .left-controls {
        width: 100%;
        max-width: 400px; /* Membatasi lebar agar tidak terlalu melar */
    }

    .custom-card {
        background: #ffffff;
        border-radius: 15px; /* Lebih bulat agar modern */
        padding: 15px 20px;
        margin-top: 15px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); /* Shadow lebih halus */
        display: flex;
        align-items: center;
        height: auto; /* Biarkan tinggi menyesuaikan konten */
    }

    .card-body-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%; /* Memastikan konten mengisi seluruh kartu */
    }

    .name {
        margin: 0;
        font-weight: 600;
        color: #64748b; /* Warna teks label agak abu agar badge menonjol */
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-number {
        background-color: #00cb0a; /* Biru sesuai gambar */
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
    .header-custom-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
        margin-bottom: 30px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin_Laporan_Perkembangan_Siswa') }}">
        <button class="back"><i class="ri-arrow-left-line"></i> Kembali</button>
    </a>
</div>
<div class="header-custom-wrapper">
    <div class="left-controls">
        <div class="profile-info">
            <h3>Yoga Aris Wibowo</h3>
        </div>

        <div class="custom-card">
            <div class="card-body-content">
                <div class="info">
                    <h5 class="name">Nilai Rata-Rata</h5>
                </div>
                <div class="badge-number">99</div>
            </div>
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
                <td>Kurang-kurangi teriak hidup jokowi saat belajar</td>
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

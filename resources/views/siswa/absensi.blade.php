@extends('layouts.app_siswa', ['title' => 'Absensi'])
@section('content')

<div class="absensi-header d-flex align-items-center justify-content-between mb-3">

    
    <div class="left-head d-flex align-items-center gap-3">
        <div class="filter-row d-flex align-items-center">
            <button class="filter-button d-flex align-items-center">
                <span>Bulan</span>
                <i class="ri-arrow-down-s-line ms-2"></i>
            </button>

            <button class="filter-button d-flex align-items-center">
                <span>Tahun</span>
                <i class="ri-arrow-down-s-line ms-2"></i>
            </button>
        </div>
    </div>

    <div class="right-head">
        <a href="#" class="btn-add d-inline-flex align-items-center">
            <span>Tambah</span>
            <i class="ri-add-line ms-2"></i>
        </a>
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
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1.</td>
                <td>Senin</td>
                <td>05–Okt–2025</td>
                <td>15.00</td>
                <td>IPAS</td>
                <td><span class="badge badge-izin">Ijin</span></td>
            </tr>

            <tr>
                <td>1.</td>
                <td>Senin</td>
                <td>05–Okt–2025</td>
                <td>15.00</td>
                <td>IPAS</td>
                <td><span class="badge badge-hadir">Hadir</span></td>
            </tr>

            <tr>
                <td>1.</td>
                <td>Senin</td>
                <td>05–Okt–2025</td>
                <td>15.00</td>
                <td>IPAS</td>
                <td><span class="badge badge-hadir">Hadir</span></td>
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

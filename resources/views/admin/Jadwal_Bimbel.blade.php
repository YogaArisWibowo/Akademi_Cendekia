@extends('layouts.app_admin', ['title' => 'Jadwal Bimbel']) @section('content')

<style>
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
    .search {
        width: 250px;
        position: relative;
        display: inline-block;
    }
    .search i {
        position: absolute;
        top: 50%; /* Pindahkan ke tengah vertikal */
        left: 8px; /* Jarak dari tepi kiri input */
        transform: translateY(
            -50%
        ); /* Penyesuaian akhir agar benar-benar di tengah */
        color: #6c757d; /* Warna abu-abu Bootstrap */
        font-size: 0.9rem; /* Atur ukuran ikon agar sesuai dengan form-control-sm */
        z-index: 2; /* Pastikan ikon berada di atas input */
    }
    .search input.form-control {
        padding-left: 30px;
        height: 30px;
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="search">
        <input
            type="search"
            class="form-control form-control-sm search-input"
            placeholder="Cari..."
            aria-label="Search"
        />
        <i class="bi bi-search"></i>
    </div>

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
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mapel</th>
                <th>Nama</th>
                <th>Nama Siswa</th>
                <th>Alamat Siswa</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($jadwal as $i => $j)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $j->hari }}</td>
                <td>{{ $j->tanggal }}</td>
                <td>{{ $j->waktu }}</td>
                <td>{{ $j->mapel }}</td>
                <td>{{ $j->guru }}</td>
                <td>{{ $j->nama_siswa }}</td>
                <td>{{ $j->alamat_siswa }}</td>
                <td>
                    <button class="btn btn-sm btn-info">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
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

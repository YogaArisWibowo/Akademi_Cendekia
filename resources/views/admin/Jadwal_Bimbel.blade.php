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
        width: 100px;
        height: 28px;
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
        margin-bottom: 5px;
        border-style: solid;
        border-width: 1px;
        border-radius: 6px;
        border-color: #cccc;
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-2">
    <div class="search-container-custom" style="width: 250px">
        <input
            type="search"
            class="form-control form-control-sm search-input"
            placeholder="Cari..."
            aria-label="Search"
        />
        <i class="bi bi-search search-icon"></i>
    </div>

    <button class="tambah text-center">
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

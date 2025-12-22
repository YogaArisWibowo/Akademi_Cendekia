@extends('layouts.app_admin', ['title' => 'Materi Pembelajaran'])

@section('content')
<style>
    .unggah {
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
    .unggah i {
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

<div class="d-flex justify-content-between align-items-center mb-4">
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
        class="unggah text-center"
        data-bs-toggle="modal"
        data-bs-target="#modalTambahJadwal"
    >
        Unggah <i class="bi bi-plus"></i>
    </button>
</div>

    <div class="materi-grid">

        @for($i=0; $i < 10; $i++)
        <a href="{{route('admin_detail_materi_pembelajaran')}}" class="materi-card-link">
            <div class="materi-card">
                <div class="materi-thumb">Gambar</div>
                <div class="materi-info">
                    <h4 class="materi-title">Bangun Datar</h4>
                </div>
            </div>
        </a>
        @endfor

    </div>

    <div class="pagination-wrapper">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page active">Selanjutnya</button>
    </div>

</div>
@endsection

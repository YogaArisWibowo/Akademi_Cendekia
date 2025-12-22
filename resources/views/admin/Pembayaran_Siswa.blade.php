@extends('layouts.app_admin', ['title' => 'Pembayaran_Bimbel'])
@section('content')

<style>
    .content-wrapper {
        padding: 20px;
    }
    .siswa-search {
    width: 250px;        /* Berikan lebar tetap agar tidak terlalu pendek */
    }
    .search-input {
        height: 35px;        /* Samakan tingginya dengan .filter-select (35px) */
        width: 80%;
        padding: 0 15px 0 40px;
        border-width: 2px;
        border-radius: 8px;
        font-size: 14px;
        background-color: transparent;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        z-index: 2;
    }

    /* GRID KARTU */
    .siswa-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 kolom */
        gap: 15px;
        margin-bottom: 20px;
    }

    .siswa-card-link {
        text-decoration: none;
        color: inherit;
    }

    .siswa-card {
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        border-radius: 8px;
        box-shadow:  0 2px 2px rgba(0, 0, 0, 0.263);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid transparent;
        padding: 5px;
    }

    .siswa-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .nama.siswa-title {
        display: block;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.2 !important;
        text-align: left !important;
    }

    .nama {
        font-weight: 600 !important;
        color: #343a40;
        font-size: 18px;
    }

    .siswa-title {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Pastikan kontainer info jenjang juga rata kiri */
    .siswa-card .siswa-info {
        margin: 0;
        font-size: 13px;
        display: block;
        text-align: left;
        color: #718096;
    }
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
    }
    .btn.page {
        margin: 0 5px;
        border-radius: 8px;
        padding: 8px 15px;
        background-color: transparent;
        color: #6c757d;
        border: none;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    .btn.page.active {
        background-color: #c9d6ff;
        color: #3f51b5;
        font-weight: bold;
    }
    .btn.page.prev-next {
        background-color: #e0eaff;
        color: #3f51b5;
    }
    .btn.page:disabled {
        background-color: #f8f9fa;
        color: #adb5bd;
    }
    .left-controls {
    display: flex;
    align-items: center; /* Menggunakan center supaya lurus tengah */
    gap: 20px;           /* Kamu bisa sesuaikan jaraknya di sini */
    margin-bottom: 25px; /* Tambahkan margin di sini saja untuk jarak ke grid kartu */
    padding: 0 20px;     /* Agar sejajar dengan content-wrapper */
}
    .controls-group {
        display: flex;
        gap: 15px;
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
        cursor: pointer;
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.203);
    }
</style>
    <div class="left-controls">
        <div class="siswa-search">
            <div class="search-input-wrapper">
                <i class="ri-search-line search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari" />
            </div>
        </div>

        <div class="controls-group">
            <select class="filter-select">
                <option selected disabled>Jenjang</option>
                <option value="TK">TK</option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
            </select>
            <select class="filter-select">
                <option selected disabled>Kelas</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>
    </div>

    <div class="content-wrapper">

        {{-- Grid Kartu Guru/Siswa --}}
        <div class="siswa-grid">
            @for($i =0; $i < 10; $i++)
            <a
                href="{{ route('admin_detail_pembayaran_siswa') }}"
                class="siswa-card-link"
            >
                <div class="siswa-card">
                    <span class="nama">Yoga</span>

                    <div class="siswa-info">
                        <span class="siswa-title">Kelas/Jenjang: SMP</span>
                    </div>
                </div>
            </a>
            @endfor
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            <button class="btn page" disabled>Sebelumnya</button>
            <button class="btn page active">1</button>
            <button class="btn page">2</button>
            <button class="btn page">3</button>
            <button class="btn page prev-next">Selanjutnya</button>
        </div>
    </div>

    @endsection
</div>

@extends('layouts.app_admin', ['title' => 'Data Guru & Siswa'])
@section('content')

<style>
    /* ----------------------------------- */
    /* CSS KUSTOM BERDASARKAN DESAIN GAMBAR */
    /* ----------------------------------- */
    
    .content-wrapper {
        padding: 20px;
    }

    /* Style untuk Search Input */
    .materi-search { margin-bottom: 25px; }
    .search-input-wrapper { position: relative; display: flex; align-items: center; }
    .search-icon { position: absolute; left: 15px; color: #adb5bd; }
    .search-input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 16px; }


    /* GRID KARTU */
    .materi-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 kolom */
        gap: 15px;
        margin-bottom: 20px;
    }

    .materi-card-link {
        text-decoration: none;
        color: inherit;
    }

    .materi-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid transparent;
        
        /* !!! PERBAIKAN KRITIS UNTUK RATA KIRI !!! */
        text-align: left !important; 
    }

    .materi-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    /* ----------------------------------- */
    /* STRUKTUR NAMA DAN JENJANG (KERAPATAN VERTIKAL + RATA KIRI) */
    /* ----------------------------------- */
    
    .nama, .materi-title {
        display: block; 
        
        /* HILANGKAN SEMUA JARAK BAWAAN (KERAPATAN) */
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.2 !important; 
        
        /* PERATAAN RATA KIRI */
        text-align: left !important; 
    }

    .nama {
        font-weight: 600 !important; 
        color: #343a40;
        font-size: 18px; 
    }

    .materi-title {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Pastikan kontainer info jenjang juga rata kiri */
    .materi-card .materi-info {
        margin: 0 !important;
        padding: 0 !important;
        text-align: left !important; 
    }

    /* ----------------------------------- */
    /* PAGINATION */
    /* ----------------------------------- */
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
</style>

<div class="content-wrapper">

    {{-- Pencarian --}}
    <div class="materi-search mb-4">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari">
        </div>
    </div>

    {{-- Grid Kartu Guru/Siswa --}}
    <div class="materi-grid">

        @for($i=0; $i<10; $i++)
        <a href="#" class="materi-card-link">
            <div class="materi-card"> 
                
                {{-- Nama (Ira Sulistya) --}}
                <span class="nama">Ira Sulistya</span>
                
                <div class="materi-info">
                    {{-- Jenjang (Guru Jenjang: SD) --}}
                    <span class="materi-title">Guru Jenjang: SD</span>
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
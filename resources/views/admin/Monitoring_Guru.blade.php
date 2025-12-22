@extends('layouts.app_admin', ['title' => 'Monitoring Guru'])
@section('content')

<style>

    .content-wrapper {
        padding: 20px;
    }

    .guru-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 kolom */
        gap: 15px;
        margin-bottom: 20px;
    }

    .guru-card-link {
        text-decoration: none;
        color: inherit;
    }

    .guru-card {
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

    .guru-card:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .nama.guru-title {
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

    .guru-title {
        font-size: 14px;
        color: #6c757d;
        font-weight: 500;
    }

    /* Pastikan kontainer info jenjang juga rata kiri */
    .guru-card .guru-info {
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

</style>

    {{-- Grid Kartu Guru/Siswa --}}
    <div class="guru-grid">
        @for($i=0; $i < 10; $i++)
        <a href="{{route('admin_detail_monitoring_guru')}}" class="guru-card-link">
            <div class="guru-card">
                {{-- Nama (Ira Sulistya) --}}
                <span class="nama">Ira Sulistya</span>

                <div class="guru-info">
                    {{-- Jenjang (Guru Jenjang: SD) --}}
                    <span class="guru-title">Guru Jenjang: SD</span>
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

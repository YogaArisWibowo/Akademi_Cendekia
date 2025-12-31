@extends('layouts.app_admin', ['title' => 'Gaji Guru'])
@section('content')

<style>
    .content-wrapper { padding: 20px; }
    .guru-search { margin-bottom: 25px; }
    .search-input-wrapper { position: relative; display: flex; align-items: center; }
    .search-icon { position: absolute; left: 15px; color: #adb5bd; }
    .search-input { width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #dee2e6; border-radius: 8px; font-size: 16px; }
    .guru-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
    .guru-card-link { text-decoration: none; color: inherit; }
    .guru-card { background: #ffffff; display: flex; flex-direction: column; align-items: flex-start; gap: 6px; border-radius: 8px; box-shadow: 0 2px 2px rgba(0, 0, 0, 0.263); transition: transform 0.2s, box-shadow 0.2s; border: 1px solid transparent; padding: 15px; }
    .guru-card:hover { box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transform: translateY(-2px); }
    .nama { font-weight: 600 !important; color: #343a40; font-size: 18px; display: block; }
    .guru-title { font-size: 14px; color: #6c757d; font-weight: 500; }
    .guru-card .guru-info { margin: 0; font-size: 13px; display: block; text-align: left; color: #718096; }
    .pagination-wrapper { display: flex; justify-content: center; align-items: center; padding: 20px 0; }
    .btn.page { margin: 0 5px; border-radius: 8px; padding: 8px 15px; background-color: transparent; color: #6c757d; border: none; font-weight: 500; }
    .btn.page.active { background-color: #c9d6ff; color: #3f51b5; font-weight: bold; }
    .btn.page.prev-next { background-color: #e0eaff; color: #3f51b5; }
</style>

<div class="content-wrapper">
    {{-- Pencarian --}}
    <div class="guru-search mb-4">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" class="search-input" id="searchInput" placeholder="Cari" />
        </div>
    </div>

    {{-- Grid Kartu Guru --}}
    <div class="guru-grid" id="guruGrid">
        @foreach($guru as $guru)
        <a href="{{ route('admin_detail_pencatatan_gaji_guru', $guru->id) }}" class="guru-card-link guru-item">
            <div class="guru-card">
                <span class="nama">{{ $guru->nama }}</span>
                <div class="guru-info">
                    <span class="guru-title">Guru Jenjang: {{ $guru->jenjang }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination (Statis sesuai permintaan) --}}
    <div class="pagination-wrapper">
        <button class="btn page" id="prevBtn" disabled>Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page prev-next" id="nextBtn">Selanjutnya</button>
    </div>
</div>

{{-- JQUERY UNTUK FITUR CARI DAN PAGINATION --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 1. Logika Pencarian Real-time
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#guruGrid .guru-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // 2. Logika Pagination Sederhana (Menangani tampilan per 10 data)
    const rowsPerPage = 10;
    const $items = $(".guru-item");
    const totalPages = Math.ceil($items.length / rowsPerPage);

    function showPage(page) {
        $items.hide();
        $items.slice((page - 1) * rowsPerPage, page * rowsPerPage).show();
        
        $(".btn.page").removeClass("active");
        $(".btn.page").filter(function() {
            return $(this).text() == page;
        }).addClass("active");

        $("#prevBtn").prop("disabled", page === 1);
        $("#nextBtn").prop("disabled", page === totalPages || totalPages === 0);
    }

    $(document).on("click", ".btn.page:not(.prev-next)", function() {
        showPage(parseInt($(this).text()));
    });

    // Inisialisasi halaman pertama
    showPage(1);
});
</script>

@endsection
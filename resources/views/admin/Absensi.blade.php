@extends('layouts.app_admin', ['title' => 'Absensi']) 

@section('content')

<style>
    /* --- UTAMA --- */
    .content-wrapper { padding: 20px; background-color: #f8faff; }
    
    /* Responsive Padding untuk HP */
    @media (max-width: 768px) {
        .content-wrapper { padding: 15px; }
    }

    .section-title { font-size: 24px; font-weight: 600; color: #0d1b3e; margin-bottom: 20px; }
    
    /* --- SEARCH --- */
    .search-input-wrapper { position: relative; width: 100%; }
    .search-input { width: 100%; padding: 12px 12px 12px 45px; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; font-size: 14px; transition: border-color 0.2s; }
    .search-input:focus { outline: none; border-color: #2b6cb0; box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1); }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #cbd5e0; font-size: 18px; }
    
    /* --- CARD --- */
    .custom-card-link { text-decoration: none !important; display: block; }
    .custom-card { 
        background: #ffffff; border-radius: 12px; padding: 16px 20px; margin-bottom: 15px; 
        border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
        transition: transform 0.2s ease, box-shadow 0.2s ease; 
    }
    .custom-card:active { transform: scale(0.98); } /* Efek klik di HP */
    .custom-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    
    .card-body-content { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    
    .info { overflow: hidden; } /* Mencegah teks keluar layout */
    .name { margin: 0; font-size: 16px; font-weight: 700; color: #1a202c; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .subtitle { margin: 4px 0 0 0; font-size: 13px; color: #718096; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    
    .badge-number { 
        background-color: #2b6cb0; color: white; width: 38px; height: 38px; flex-shrink: 0;
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        font-weight: 600; box-shadow: 0 4px 6px rgba(43, 108, 176, 0.3); 
    }

    /* --- PAGINATION --- */
    .pagination-container { display: flex; gap: 8px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
    .btn-page { border: none; background: transparent; padding: 8px 16px; border-radius: 8px; font-size: 14px; color: #4a5568; cursor: pointer; transition: 0.2s; }
    .btn-page:hover { background-color: #edf2f7; }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; }
    .btn-page.next, .btn-page.prev { background-color: #c3dafe; color: #1a365d; font-weight: 500; }
    .btn-page:disabled { cursor: default; background-color: #f7fafc; color: #cbd5e0; }

    /* --- RESPONSIVE MOBILE TWEAKS --- */
    @media (max-width: 576px) {
        .section-title { font-size: 20px; margin-bottom: 15px; }
        .custom-card { padding: 12px 15px; }
        .name { font-size: 14px; }
        .subtitle { font-size: 12px; }
        .badge-number { width: 32px; height: 32px; font-size: 12px; }
        
        /* Tombol Pagination lebih kecil di HP */
        .btn-page { padding: 6px 12px; font-size: 12px; }
    }
</style>

<div class="content-wrapper">
    {{-- Menggunakan g-4 untuk jarak antar kolom yang rapi --}}
    <div class="row g-4">
        
        {{-- KOLOM GURU --}}
        {{-- col-12 (HP Penuh), col-lg-6 (Laptop Setengah) --}}
        <div class="col-12 col-lg-6">
            <h3 class="section-title">Absensi Guru</h3>
            <form action="{{ route('admin_Absensi') }}" method="GET">
                <div class="search-input-wrapper mb-3">
                    <i class="ri-search-line search-icon"></i>
                    <input type="text" name="search_guru" class="search-input" placeholder="Cari Guru..." value="{{ request('search_guru') }}">
                </div>
            </form>

            <div class="list-wrapper" id="absensiGuru">
                @forelse($data_guru as $guru)
                <a href="{{ route('admin_detail_absensi_guru', $guru->id) }}" class="custom-card-link item-card">
                    <div class="custom-card">
                        <div class="card-body-content">
                            <div class="info">
                                <h5 class="name">{{ $guru->nama }}</h5>
                                <p class="subtitle">Guru Mapel : {{ $guru->mapel ?? '-' }}</p>
                            </div>
                            <div class="badge-number">{{ $guru->absensi_guru_count }}</div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-4 text-muted">Data Guru tidak ditemukan.</div>
                @endforelse
            </div>
            
            <div class="pagination-container" id="paginationGuru"></div>
            
            {{-- Spacer khusus Mobile agar ada jarak antara Guru dan Siswa saat ditumpuk --}}
            <div class="d-block d-lg-none mb-4"></div>
        </div>

        {{-- KOLOM SISWA --}}
        <div class="col-12 col-lg-6">
            <h3 class="section-title">Absensi Siswa</h3>
            <form action="{{ route('admin_Absensi') }}" method="GET">
                <div class="search-input-wrapper mb-3">
                    <i class="ri-search-line search-icon"></i>
                    <input type="text" name="search_siswa" class="search-input" placeholder="Cari Siswa..." value="{{ request('search_siswa') }}">
                </div>
            </form>

            <div class="list-wrapper" id="absensiSiswa">
                @forelse($data_siswa as $siswa)
                <a href="{{ route('admin_detail_absensi_siswa', $siswa->id) }}" class="custom-card-link item-card">
                    <div class="custom-card">
                        <div class="card-body-content">
                            <div class="info">
                                <h5 class="name">{{ $siswa->nama }}</h5>
                                <p class="subtitle">Kelas : {{ $siswa->jenjang ?? '-' }}</p>
                            </div>
                            <div class="badge-number">{{ $siswa->absensi_siswa_count }}</div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-4 text-muted">Data Siswa tidak ditemukan.</div>
                @endforelse
            </div>
            
            <div class="pagination-container" id="paginationSiswa"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // FUNGSI PAGINATION YANG SAMA
    function setupPagination(wrapperId, paginationId) {
        const rowsPerPage = 10; 
        let currentPage = 1;
        
        const $wrapper = $('#' + wrapperId);
        const $container = $('#' + paginationId);
        
        function render() {
            const $items = $wrapper.find('.custom-card-link');
            const totalItems = $items.length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            
            $container.empty();
            
            if (totalPages > 1) {
                // Tombol Prev
                $container.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                
                // Angka
                for (let i = 1; i <= totalPages; i++) {
                    $container.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                }
                
                // Tombol Next
                $container.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
            }
            
            $items.hide();
            $items.slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();
        }

        $container.off('click', '.num').on('click', '.num', function() {
            currentPage = parseInt($(this).data('page'));
            render();
            // Scroll sedikit ke atas agar user sadar halaman berubah (Optional UX)
            $('html, body').animate({ scrollTop: $wrapper.offset().top - 100 }, 300);
        });

        $container.off('click', '.prev').on('click', '.prev', function() {
            if (currentPage > 1) { currentPage--; render(); }
        });

        $container.off('click', '.next').on('click', '.next', function() {
            const totalItems = $wrapper.find('.custom-card-link').length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            if (currentPage < totalPages) { currentPage++; render(); }
        });

        render();
    }

    setupPagination('absensiGuru', 'paginationGuru');
    setupPagination('absensiSiswa', 'paginationSiswa');
});
</script>

@endsection
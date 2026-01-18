@extends('layouts.app_admin', ['title' => 'Absensi']) 

@section('content')

<style>
    /* --- STYLE TETAP SAMA SEPERTI SEBELUMNYA --- */
    .content-wrapper { padding: 20px; background-color: #f8faff; }
    @media (max-width: 768px) { .content-wrapper { padding: 15px; } }
    .section-title { font-size: 24px; font-weight: 600; color: #0d1b3e; margin-bottom: 20px; }
    
    .search-input-wrapper { position: relative; width: 100%; }
    .search-input { 
        width: 100%; padding: 12px 12px 12px 45px; 
        border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; 
        font-size: 14px; transition: border-color 0.2s; 
    }
    .search-input:focus { outline: none; border-color: #2b6cb0; box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1); }
    
    /* Tombol Search */
    .btn-search-trigger { 
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%); 
        border: none; background: transparent; color: #cbd5e0; 
        font-size: 18px; cursor: pointer; padding: 5px; z-index: 10;
        transition: color 0.2s;
    }
    .btn-search-trigger:hover { color: #2b6cb0; }
    
    .custom-card-link { text-decoration: none !important; display: block; }
    .custom-card { 
        background: #ffffff; border-radius: 12px; padding: 16px 20px; margin-bottom: 15px; 
        border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
        transition: transform 0.2s ease, box-shadow 0.2s ease; 
    }
    .custom-card:active { transform: scale(0.98); }
    .custom-card:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    
    .card-body-content { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .info { overflow: hidden; }
    .name { margin: 0; font-size: 16px; font-weight: 700; color: #1a202c; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .subtitle { margin: 4px 0 0 0; font-size: 13px; color: #718096; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .badge-number { 
        background-color: #2b6cb0; color: white; width: 38px; height: 38px; flex-shrink: 0;
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        font-weight: 600; box-shadow: 0 4px 6px rgba(43, 108, 176, 0.3); 
    }

    .pagination-container { display: flex; gap: 8px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
    .btn-page { border: none; background: transparent; padding: 8px 16px; border-radius: 8px; font-size: 14px; color: #4a5568; cursor: pointer; transition: 0.2s; }
    .btn-page:hover { background-color: #edf2f7; }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; }
    .btn-page.next, .btn-page.prev { background-color: #c3dafe; color: #1a365d; font-weight: 500; }
    .btn-page:disabled { cursor: default; background-color: #f7fafc; color: #cbd5e0; }
    
    /* Utility class untuk menyembunyikan item yang tidak cocok saat search */
    .hidden-by-search { display: none !important; }
</style>

<div class="content-wrapper">
    <div class="row g-4">
        
        {{-- KOLOM GURU --}}
        <div class="col-12 col-lg-6">
            <h3 class="section-title">Absensi Guru</h3>
            
            {{-- SEARCH GURU (Tanpa Form, Menggunakan ID) --}}
            <div class="search-input-wrapper mb-3">
                <button type="button" class="btn-search-trigger" id="btnSearchGuru">
                    <i class="ri-search-line"></i>
                </button>
                <input type="text" id="inputSearchGuru" class="search-input" placeholder="Cari Guru...">
            </div>

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
                {{-- Pesan jika pencarian tidak ketemu --}}
                <div class="text-center py-4 text-muted not-found-msg" style="display:none;">Tidak ada hasil pencarian.</div>
            </div>
            
            <div class="pagination-container" id="paginationGuru"></div>
            <div class="d-block d-lg-none mb-4"></div>
        </div>

        {{-- KOLOM SISWA --}}
        <div class="col-12 col-lg-6">
            <h3 class="section-title">Absensi Siswa</h3>
            
            {{-- SEARCH SISWA (Tanpa Form, Menggunakan ID) --}}
            <div class="search-input-wrapper mb-3">
                <button type="button" class="btn-search-trigger" id="btnSearchSiswa">
                    <i class="ri-search-line"></i>
                </button>
                <input type="text" id="inputSearchSiswa" class="search-input" placeholder="Cari Siswa...">
            </div>

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
                <div class="text-center py-4 text-muted not-found-msg" style="display:none;">Tidak ada hasil pencarian.</div>
            </div>
            
            <div class="pagination-container" id="paginationSiswa"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // Fungsi Utama: Menggabungkan Pencarian & Pagination
    function initListManager(wrapperId, inputId, paginationId) {
        const rowsPerPage = 10; 
        let currentPage = 1;
        
        const $wrapper = $('#' + wrapperId);
        const $input = $('#' + inputId);
        const $container = $('#' + paginationId);
        const $msgNotFound = $wrapper.find('.not-found-msg');

        // 1. Logika Filtering (Search)
        function filterData() {
            const query = $input.val().toLowerCase();
            const $allCards = $wrapper.find('.custom-card-link');
            
            $allCards.each(function() {
                const name = $(this).find('.name').text().toLowerCase();
                const subtitle = $(this).find('.subtitle').text().toLowerCase();
                
                // Cek apakah nama atau subtitle mengandung text pencarian
                if (name.includes(query) || subtitle.includes(query)) {
                    $(this).removeClass('hidden-by-search');
                } else {
                    $(this).addClass('hidden-by-search');
                }
            });

            // Reset ke halaman 1 setiap kali search berubah
            currentPage = 1; 
            renderPagination();
        }

        // 2. Logika Pagination (Hanya menampilkan item yang lolos search)
        function renderPagination() {
            // Ambil hanya item yang TIDAK disembunyikan oleh search
            const $visibleItems = $wrapper.find('.custom-card-link').not('.hidden-by-search');
            const totalItems = $visibleItems.length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            
            // Tampilkan Pesan "Tidak ada hasil" jika kosong
            if (totalItems === 0) {
                $msgNotFound.show();
                $container.empty();
                return;
            } else {
                $msgNotFound.hide();
            }

            // Render Tombol Pagination
            $container.empty();
            if (totalPages > 1) {
                $container.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                for (let i = 1; i <= totalPages; i++) {
                    $container.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                }
                $container.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
            }

            // Sembunyikan SEMUA item dulu
            $wrapper.find('.custom-card-link').hide();

            // Tampilkan HANYA item yang sesuai search DAN sesuai halaman saat ini
            $visibleItems
                .slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage)
                .fadeIn(200); // Pakai animasi sedikit biar halus
        }

        // EVENT LISTENER
        // Jalankan filter saat mengetik (Live Search)
        $input.on('keyup', function() {
            filterData();
        });

        // Jalankan filter saat tombol kaca pembesar diklik (untuk UX)
        $input.siblings('.btn-search-trigger').on('click', function() {
            filterData();
        });

        // Event Pagination (Klik Angka/Next/Prev)
        $container.off('click', '.num').on('click', '.num', function() {
            currentPage = parseInt($(this).data('page'));
            renderPagination();
            $('html, body').animate({ scrollTop: $wrapper.offset().top - 100 }, 300);
        });

        $container.off('click', '.prev').on('click', '.prev', function() {
            if (currentPage > 1) { currentPage--; renderPagination(); }
        });

        $container.off('click', '.next').on('click', '.next', function() {
            const totalItems = $wrapper.find('.custom-card-link').not('.hidden-by-search').length;
            const totalPages = Math.ceil(totalItems / rowsPerPage);
            if (currentPage < totalPages) { currentPage++; renderPagination(); }
        });

        // Render awal saat halaman dimuat
        renderPagination();
    }

    // Inisialisasi untuk Guru
    initListManager('absensiGuru', 'inputSearchGuru', 'paginationGuru');
    
    // Inisialisasi untuk Siswa
    initListManager('absensiSiswa', 'inputSearchSiswa', 'paginationSiswa');
});
</script>

@endsection
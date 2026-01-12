@extends('layouts.app_admin', ['title' => 'Monitoring Guru'])
@section('content')

{{-- CSS --}}
<style>
    .content-wrapper { padding: 20px; }
    
    .guru-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px; /* Jarak sedikit diperlebar */
        margin-bottom: 20px;
    }

    .guru-card-link { text-decoration: none; color: inherit; }

    .guru-card {
        background: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #e2e8f0;
        padding: 15px;
        position: relative; 
        overflow: hidden;
        height: 100%; /* Agar tinggi kartu seragam */
    }

    .guru-card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
        border-color: #3b82f6;
    }

    /* --- BADGES CONTAINER --- */
    .badge-container {
        position: absolute;
        top: 0;
        right: 0;
        display: flex;
        flex-direction: column; /* Badge ditumpuk ke bawah */
        align-items: flex-end;
    }

    .star-badge {
        padding: 4px 12px;
        color: white;
        font-weight: 700;
        font-size: 11px;
        box-shadow: -2px 2px 5px rgba(0,0,0,0.15);
        z-index: 2;
        margin-bottom: 0; /* Rapat */
        border-bottom-left-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* WARNA BADGE RAJIN (Kuning/Emas) */
    .badge-rajin-1 { background: linear-gradient(45deg, #FFD700, #FDB931); } 
    .badge-rajin-2 { background: linear-gradient(45deg, #C0C0C0, #E0E0E0); } 
    .badge-rajin-3 { background: linear-gradient(45deg, #CD7F32, #D2691E); }

    /* WARNA BADGE CEPAT (Biru/Ungu - Flash) */
    .badge-cepat-1 { background: linear-gradient(45deg, #00c6ff, #0072ff); width: 100px; text-align: right; }
    .badge-cepat-2 { background: linear-gradient(45deg, #a18cd1, #fbc2eb); width: 90px; text-align: right; }
    .badge-cepat-3 { background: linear-gradient(45deg, #84fab0, #8fd3f4); width: 80px; text-align: right; color: #333; }

    /* Highlight Border untuk Juara 1 Rajin */
    .border-gold { border: 2px solid #FFD700;
                   background-color: white; }

    .nama { font-weight: 700 !important; color: #1f2937; font-size: 18px; margin-top: 10px; /* Jarak karena ada badge */ }
    .guru-title { font-size: 14px; color: #6b7280; font-weight: 500; }
    
    .stats-row {
        display: flex;
        gap: 15px;
        margin-top: 8px;
        font-size: 12px;
        width: 100%;
        border-top: 1px solid #f3f4f6;
        padding-top: 8px;
    }
    .stat-item { display: flex; align-items: center; gap: 4px; }

    /* --- PAGINATION STYLE --- */
    .pagination-wrapper { display: flex; justify-content: center; margin-top: 20px; gap: 5px; }
    .btn-page { border: 1px solid #d1d5db; background: white; padding: 8px 14px; border-radius: 6px; cursor: pointer; }
    .btn-page.active { background: #3b82f6; color: white; border-color: #3b82f6; }
    .btn-page:disabled { background: #f9fafb; color: #9ca3af; }
</style>

<div class="content-wrapper">
    
    <div class="guru-grid" id="guruGrid">
        
        @forelse($gurus as $guru)
            <div class="guru-item"> 
                <a href="{{route('admin_detail_monitoring_guru', $guru->id)}}" class="guru-card-link">
                    
                    @php
                        // Cek Ranking Rajin (Berdasarkan ID yang dikirim Controller)
                        // array_search mengembalikan index (0 = Juara 1, 1 = Juara 2, dst)
                        $posisiRajin = array_search($guru->id, $rankRajinIds); 
                        $isRajin = $posisiRajin !== false;

                        // Cek Ranking Cepat
                        $posisiCepat = array_search($guru->id, $rankCepatIds);
                        $isCepat = $posisiCepat !== false;

                        // Tambahan Class Border Khusus Juara 1 Rajin
                        $cardClass = ($isRajin && $posisiRajin === 0) ? 'border-gold' : '';
                    @endphp

                    <div class="guru-card {{ $cardClass }}">
                        
                        {{-- CONTAINER BADGE (Pojok Kanan Atas) --}}
                        <div class="badge-container">
                            
                            {{-- BADGE RAJIN (TOTAL) --}}
                            @if($isRajin)
                                <div class="star-badge badge-rajin-{{ $posisiRajin + 1 }}">
                                    <i class="ri-medal-fill"></i> 
                                    @if($posisiRajin == 0) #1 TERAJIN 
                                    @elseif($posisiRajin == 1) #2 RAJIN 
                                    @else #3 RAJIN @endif
                                </div>
                            @endif

                            {{-- BADGE CEPAT (RATA-RATA WAKTU) --}}
                            @if($isCepat)
                                <div class="star-badge badge-cepat-{{ $posisiCepat + 1 }}">
                                    <i class="ri-timer-flash-line"></i>
                                    @if($posisiCepat == 0) #1 TERCEPAT 
                                    @elseif($posisiCepat == 1) #2 CEPAT 
                                    @else #3 CEPAT @endif
                                </div>
                            @endif

                        </div>

                        <span class="nama">{{ $guru->nama }}</span>
                        
                        <div class="guru-info">
                            <span class="guru-title">Mapel: {{ $guru->mapel ?? '-' }}</span>
                        </div>

                        {{-- Statistik Kecil di Bawah --}}
                        <div class="stats-row">
                            <div class="stat-item" title="Total Kehadiran">
                                <i class="ri-check-double-line" style="color: #10b981;"></i> 
                                <strong>{{ $guru->total_hadir }}</strong> Hadir
                            </div>
                            <div class="stat-item" title="Rata-rata Jam Datang">
                                <i class="ri-time-line" style="color: #3b82f6;"></i> 
                                Avg: <strong>{{ $guru->rata_rata_str }}</strong>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
        @empty
            <div class="alert alert-info w-100" style="grid-column: span 2;">
                Belum ada data guru.
            </div>
        @endforelse

    </div>

    {{-- Pagination JS (Sama seperti sebelumnya) --}}
    <div id="paginationGuru" class="pagination-wrapper"></div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const rowsPerPage = 10; 
        const $items = $("#guruGrid .guru-item"); 
        const $paginationContainer = $("#paginationGuru");
        let currentPage = 1;

        if ($items.length === 0) {
            $paginationContainer.hide();
            return;
        }

        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            $items.hide().slice(start, end).fadeIn(300);
            renderButtons();
        }

        function renderButtons() {
            const totalRows = $items.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            $paginationContainer.empty();
            if (totalPages <= 1) return;

            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            $paginationContainer.append(`<button type="button" class="btn-page prev" ${prevDisabled}>Sebelumnya</button>`);

            for (let i = 1; i <= totalPages; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                $paginationContainer.append(`<button type="button" class="btn-page num ${activeClass}" data-page="${i}">${i}</button>`);
            }

            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            $paginationContainer.append(`<button type="button" class="btn-page next" ${nextDisabled}>Selanjutnya</button>`);
        }

        $(document).on("click", ".num", function() { showPage($(this).data("page")); });
        $(document).on("click", ".prev", function() { if (currentPage > 1) showPage(currentPage - 1); });
        $(document).on("click", ".next", function() { 
            const totalPages = Math.ceil($items.length / rowsPerPage);
            if (currentPage < totalPages) showPage(currentPage + 1); 
        });

        showPage(1);
    });
</script>

@endsection
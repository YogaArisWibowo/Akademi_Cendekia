@extends('layouts.app_siswa', ['title' => 'Video Materi'])

@section('content')

    {{-- Form Pencarian --}}
    <div class="materi-search mb-4">
        <form action="{{ route('siswa.video') }}" method="GET" class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" name="search" class="search-input" placeholder="Cari Materi..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="video-grid">
        @forelse($videos as $video)
            {{-- Logic untuk mengambil ID Youtube agar bisa menampilkan Thumbnail --}}
            @php
                $video_id = '';
                $url = $video->link_video;
                if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
                    $video_id = $id[1];
                } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
                    $video_id = $id[1];
                }
                $thumbnail = $video_id ? "https://img.youtube.com/vi/{$video_id}/mqdefault.jpg" : null;
            @endphp

            <div class="video-card">
                <div class="video-thumb">
                    @if($thumbnail)
                        {{-- Klik gambar langsung ke link youtube --}}
                        <a href="{{ $video->link_video }}" target="_blank">
                            <img src="{{ $thumbnail }}" alt="Thumbnail" style="width:100%; height:100%; object-fit:cover; border-radius: 8px;">
                        </a>
                    @else
                        <div style="display:flex; align-items:center; justify-content:center; height:100%; background:#ddd; color:#666;">
                            NO IMAGE
                        </div>
                    @endif
                </div>
                
                <div class="video-info">
                    {{-- Batasi panjang link agar tidak merusak layout --}}
                    <p>
                        <strong>Link Youtube :</strong> 
                        <a href="{{ $video->link_video }}" target="_blank" style="color: blue; text-decoration: underline;">
                            {{ Str::limit($video->link_video, 25) }}
                        </a>
                    </p>
                    
                    <p><strong>Materi :</strong></p>
                    {{-- Karena di DB tidak ada kolom ringkasan, kita pakai nama_materi --}}
                    <p>{{ $video->nama_materi }}</p>
                    
                    {{-- Opsional: Tampilkan jenis kurikulum --}}
                    <small class="text-muted" style="font-size: 12px; color: grey;">
                        Kurikulum: {{ $video->jenis_kurikulum }}
                    </small>
                </div>
            </div>

        @empty
            <div class="col-12" style="grid-column: 1 / -1; text-align: center; padding: 20px;">
                <p>Tidak ada video materi ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- Kita gunakan logic pagination Laravel tapi styling manual sesuai gambar kamu --}}
    @if ($videos->hasPages())
    <div class="pagination-wrapper">
        {{-- Tombol Sebelumnya --}}
        @if ($videos->onFirstPage())
            <button class="btn page" disabled>Sebelumnya</button>
        @else
            <a href="{{ $videos->previousPageUrl() }}" class="btn page">Sebelumnya</a>
        @endif

        {{-- Loop Nomor Halaman --}}
        @foreach ($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
            {{-- Tampilkan maksimal beberapa page saja agar tidak kepanjangan --}}
            @if ($page == $videos->currentPage())
                <button class="btn page active">{{ $page }}</button>
            @elseif($page == 1 || $page == $videos->lastPage() || abs($page - $videos->currentPage()) < 2)
                <a href="{{ $url }}" class="btn page">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Tombol Selanjutnya --}}
        @if ($videos->hasMorePages())
            <a href="{{ $videos->nextPageUrl() }}" class="btn page active">Selanjutnya</a>
        @else
            <button class="btn page" disabled>Selanjutnya</button>
        @endif
    </div>
    @endif

@endsection
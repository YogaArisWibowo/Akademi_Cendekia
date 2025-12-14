@extends('layouts.app_guru', ['title' => 'Video Materi'])

@section('content')


    <div class="materi-search mb-4">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari">
        </div>
    </div>

    <!-- Grid Video -->
    <div class="video-grid">

        <!-- CARD VIDEO -->
        <div class="video-card">
            <div class="video-thumb">GAMBAR</div>
            <div class="video-info">
                <p><strong>Link Youtube :</strong> https://youtu.be/test123</p>
                <p><strong>Ringkasan :</strong></p>
                <p>Lingkaran adalah bangun datar yang memiliki titik pusat...</p>
            </div>
        </div>

        <div class="video-card">
            <div class="video-thumb">GAMBAR</div>
            <div class="video-info">
                <p><strong>Link Youtube :</strong> https://youtu.be/test123</p>
                <p><strong>Ringkasan :</strong></p>
                <p>Lingkaran adalah bangun datar yang memiliki titik pusat...</p>
            </div>
        </div>

        <div class="video-card">
            <div class="video-thumb">GAMBAR</div>
            <div class="video-info">
                <p><strong>Link Youtube :</strong> https://youtu.be/test123</p>
                <p><strong>Ringkasan :</strong></p>
                <p>Lingkaran adalah bangun datar yang memiliki titik pusat...</p>
            </div>
        </div>

        <div class="video-card">
            <div class="video-thumb">GAMBAR</div>
            <div class="video-info">
                <p><strong>Link Youtube :</strong> https://youtu.be/test123</p>
                <p><strong>Ringkasan :</strong></p>
                <p>Lingkaran adalah bangun datar yang memiliki titik pusat...</p>
            </div>
        </div>

        <div class="video-card">
            <div class="video-thumb">GAMBAR</div>
            <div class="video-info">
                <p><strong>Link Youtube :</strong> https://youtu.be/test123</p>
                <p><strong>Ringkasan :</strong></p>
                <p>Lingkaran adalah bangun datar yang memiliki titik pusat...</p>
            </div>
        </div>

        <div class="video-card">
            <div class="video-thumb">GAMBAR</div>
            <div class="video-info">
                <p><strong>Link Youtube :</strong> https://youtu.be/test123</p>
                <p><strong>Ringkasan :</strong></p>
                <p>Lingkaran adalah bangun datar yang memiliki titik pusat...</p>
            </div>
        </div>

    </div>

     <div class="pagination-wrapper">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page active">Selanjutnya</button>
    </div>



@endsection
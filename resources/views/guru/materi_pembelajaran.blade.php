@extends('layouts.app_guru', ['title' => 'Materi Pembelajaran'])

@section('content')
<div class="content-wrapper">

    <div class="materi-search mb-4">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari">
        </div>
    </div>

    <div class="materi-grid">

        @for($i=0; $i<10; $i++)
        <a href="{{ route('detail_materi_pembelajaran') }}" class="materi-card-link">
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

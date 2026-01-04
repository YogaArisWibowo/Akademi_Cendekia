@extends('layouts.app_siswa', ['title' => 'Materi Pembelajaran'])

@section('content')
    <div class="content-wrapper">

        {{-- Form Pencarian --}}
        <div class="materi-search mb-4">
            <form action="{{ route('siswa.siswa_daftarmateri') }}" method="GET" class="search-input-wrapper"
                style="display: flex; align-items: center;">

                <button type="submit"
                    style="background:none; border:none; padding:0; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="ri-search-line search-icon"></i>
                </button>

                <input type="text" name="search" class="search-input" placeholder="Cari Materi..."
                    value="{{ request('search') }}" style="margin-left: 5px;">
            </form>
        </div>

        <div class="materi-grid">
            {{-- Looping Data dari Controller ($materis) --}}
            @forelse($materis as $item)
                <a href="{{ route('siswa.materi.detail', $item->id) }}" class="materi-card-link">
                    <div class="materi-card">
                        <div class="materi-thumb">
                            {{-- Placeholder Gambar --}}
                            <span style="font-size: 40px; color: #ccc;"><i class="ri-book-open-line"></i></span>
                        </div>
                        <div class="materi-info">
                            <h4 class="materi-title">{{ $item->nama_materi }}</h4>
                            {{-- PERBAIKAN: Gunakan ?-> untuk keamanan jika mapel null --}}
                            <small style="color: #666;">{{ $item->mapel?->nama_mapel ?? 'Mapel Umum' }}</small>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-12" style="grid-column: 1/-1; text-align: center; padding: 20px;">
                    <p>Belum ada materi pembelajaran.</p>
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $materis->withQueryString()->links() }}
        </div>

    </div>
@endsection

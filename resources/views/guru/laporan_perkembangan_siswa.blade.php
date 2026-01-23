@extends('layouts.app_guru', ['title' => 'Laporan Perkembangan Siswa'])

@section('content')
    <div class="content-wrapper">

        <form action="{{ route('laporan_perkembangan_siswa') }}" method="GET" class="materi-search mb-4">
            <div class="search-input-wrapper">
                {{-- Icon Search --}}
                <i class="ri-search-line search-icon"></i>

                {{-- Tambahkan name="search" dan value agar tulisan tidak hilang saat di-enter --}}
                <input type="text" name="search" class="search-input" placeholder="Cari" value="{{ request('search') }}">
            </div>
        </form>

        <div class="materi-grid">
            @foreach ($siswa as $item)
                <a href="{{ route('detail_laporan_perkembangan_siswa', ['id' => $item->id]) }}" class="materi-card-link">
                    <div class="materi-card">
                        <div class="materi-info">
                            <h4 class="materi-title">{{ $item->nama }}</h4>
                            <p class="materi-subtitle">Kelas/jenjang : {{ $item->kelas }} / {{ $item->jenjang }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
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

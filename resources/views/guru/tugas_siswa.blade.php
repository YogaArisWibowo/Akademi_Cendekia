@extends('layouts.app_guru', ['title' => 'Tugas Siswa'])

@section('content')
    <div class="content-wrapper">

        

        <div class="materi-grid">
            @foreach ($siswa as $item)
                <a href="{{ route('detail_tugas_siswa', ['id' => $item->id]) }}" class="materi-card-link">
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

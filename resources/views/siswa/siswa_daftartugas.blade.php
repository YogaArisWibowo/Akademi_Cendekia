@extends('layouts.app_siswa', ['title' => 'Tugas Siswa'])

@section('content')
    <div class="daftar-tugas-container">

        {{-- Gunakan @forelse: Melakukan looping jika ada data, menampilkan pesan jika kosong --}}
        @forelse($daftar_tugas as $tugas)
            {{-- Struktur HTML ini 100% sama dengan desain aslimu --}}
            <a href="{{ route('siswa.tugas.show', $tugas->id) }}" class="tugas-card-link">
                <div class="tugas-card">
                    <div class="tugas-header">
                        <div class="icon-wrapper">
                            <i class="ri-todo-fill"></i>
                        </div>
                        <div>
                            {{-- Mengambil Judul Tugas dari Database --}}
                            <h4 class="tugas-title">{{ $tugas->penugasan }}</h4>

                            {{-- Mengambil Tanggal dan diformat jadi (Tgl Bulan) contoh: 11 Nov --}}
                            <span class="tanggal">
                                {{ \Carbon\Carbon::parse($tugas->tanggal)->format('d M') }}
                            </span>
                        </div>
                    </div>
                </div>
            </a>

        @empty
            {{-- Tampilan jika TIDAK ADA data tugas (Tetap rapi) --}}
            <div class="alert alert-info text-center" style="margin-top: 20px;">
                Belum ada tugas untuk saat ini.
            </div>
        @endforelse

    </div>
@endsection

@extends('layouts.app_siswa', ['title' => 'Detail Materi'])

@section('content')
    <div class="content-wrapper">

        {{-- Tombol Kembali --}}
        <a href="/siswa/materi" class="back-btn">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>

        {{-- Judul Materi --}}
        <h3 class="materi-detail-title">{{ $materi->nama_materi }}</h3>

        <div class="materi-detail-card">
            {{-- Header: Label dan Tombol Download --}}
            {{-- Ganti blok tombol download dengan ini --}}
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <div>
                    <p style="margin-bottom: 5px;"><strong>Mata Pelajaran:</strong> {{ $materi->mapel->nama_mapel ?? '-' }}
                    </p>
                    <p style="margin-bottom: 0;"><strong>Guru:</strong> {{ $materi->guru->nama ?? '-' }}</p>
                </div>

                {{-- KODE YANG BENAR (Perhatikan pasangan if-else-endif nya) --}}
                @if ($materi->file_materi)
                    <a href="{{ route('siswa.download.materi', $materi->id) }}" class="btn-download"
                        style="background-color: #28a745; color: white; padding: 8px 20px; text-decoration: none; border-radius: 8px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s;">
                        <i class="ri-download-line"></i> Unduh File
                    </a>
                @else
                    <button disabled
                        style="background-color: #ccc; color: #666; padding: 8px 20px; border: none; border-radius: 8px; cursor: not-allowed;">
                        File Tidak Tersedia
                    </button>
                @endif
            </div>

            {{-- Isi Materi --}}
            <div class="materi-content">
                <p><strong>Deskripsi / Materi :</strong></p>
                <p>
                    {{-- Menampilkan isi materi (mendukung enter/baris baru) --}}
                    {!! nl2br(e($materi->materi)) !!}
                </p>
            </div>

        </div>

    </div>
@endsection

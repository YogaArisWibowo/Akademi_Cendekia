@extends('layouts.app_guru', ['title' => 'Video Materi'])

@section('content')
    <div class="materi-search mb-4 d-flex justify-content-between align-items-center">
        <form action="{{ route('video_materi_belajar') }}" method="GET" class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" name="search" class="search-input" placeholder="Cari" value="{{ request('search') }}">
        </form>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
            Unggah +
        </button>
    </div>

    <div class="video-grid">
        @foreach ($video as $v)
            <div class="video-card">
                <div class="video-thumb">
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                        <i class="ri-video-line ri-3x"></i>
                    </div>
                </div>
                <div class="video-info">
                    <h5>{{ $v->nama_materi }}</h5>
                    <p><strong>Mapel:</strong> {{ $v->mapel->nama_mapel ?? '-' }}</p>
                    <p><strong>Link:</strong> <a href="{{ $v->link_video }}" target="_blank">Buka Video</a></p>
                    <p><strong>Kurikulum:</strong> {{ $v->jenis_kurikulum }}</p>
                </div>
                <div class="video-edit">
                    <button type="button" class="edit-icon" data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $v->id }}">
                        <i class="ri-pencil-line"></i>
                    </button>
                </div>
            </div>

            <div class="modal fade" id="modalEdit{{ $v->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('update_video_materi', $v->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Video Materi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama Materi</label>
                                    <input type="text" name="nama_materi" class="form-control"
                                        value="{{ $v->nama_materi }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Link Youtube</label>
                                    <input type="text" name="link_video" class="form-control"
                                        value="{{ $v->link_video }}" required>
                                </div>

                                {{-- Mapel & Kurikulum di Edit biasanya tidak diubah, tapi kita tampilkan saja --}}
                                <div class="mb-3">
                                    <label class="form-label">Mata Pelajaran</label>
                                    <input type="text" class="form-control" value="{{ $v->mapel->nama_mapel ?? '-' }}"
                                        readonly style="background-color: #e9ecef;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Kurikulum</label>
                                    {{-- Mengambil kurikulum dari tabel Mapel sesuai relasi --}}
                                    <input type="text" name="jenis_kurikulum" class="form-control"
                                        value="{{ $v->mapel->jenis_kurikulum ?? $v->jenis_kurikulum }}" readonly
                                        style="background-color: #e9ecef;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('store_video_materi') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Video Materi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        {{-- 1. BAGIAN GURU (Otomatis & Readonly) --}}
                        <div class="mb-3">
                            <label>Guru</label>
                            {{-- Input Hidden untuk mengirim ID ke database --}}
                            <input type="hidden" name="id_guru" value="{{ $guru_login->id }}">
                            {{-- Input Text Tampil hanya untuk dilihat user --}}
                            <input type="text" class="form-control" value="{{ $guru_login->nama }}" readonly
                                style="background-color: #e9ecef;">
                        </div>

                        {{-- 2. BAGIAN SISWA (Dropdown Filtered) --}}
                        <div class="mb-3">
                            <label>Siswa (Opsional)</label>
                            <select name="id_siswa" class="form-control">
                                <option value="">-- Semua Siswa (Kelas Saya) --</option>
                                @foreach ($siswa_ampu as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- 3. BAGIAN MAPEL (Otomatis dari Jadwal/Guru & Readonly) --}}
                        <div class="mb-3">
                            <label>Mata Pelajaran</label>
                            @if ($mapel_guru)
                                <input type="hidden" name="id_mapel" value="{{ $mapel_guru->id }}">
                                <input type="text" class="form-control" value="{{ $mapel_guru->nama_mapel }}"
                                    readonly style="background-color: #e9ecef;">
                            @else
                                <div class="alert alert-danger">Anda belum memiliki Jadwal Mapel.</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label>Nama Materi</label>
                            <input type="text" name="nama_materi" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Link Video</label>
                            <input type="text" name="link_video" class="form-control" required>
                        </div>

                        {{-- 4. BAGIAN KURIKULUM (Otomatis dari tabel Mapel) --}}
                        <div class="mb-3">
                            <label>Jenis Kurikulum</label>
                            @if ($mapel_guru)
                                {{-- Mengambil kolom jenis_kurikulum dari tabel Mapel --}}
                                <input type="text" name="jenis_kurikulum" class="form-control"
                                    value="{{ $mapel_guru->jenis_kurikulum }}" readonly
                                    style="background-color: #e9ecef;">
                            @else
                                <input type="text" name="jenis_kurikulum" class="form-control"
                                    placeholder="Kurikulum tidak ditemukan" readonly>
                            @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"
                            {{ !$mapel_guru ? 'disabled' : '' }}>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

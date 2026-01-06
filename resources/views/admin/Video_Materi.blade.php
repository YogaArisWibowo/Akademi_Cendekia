@extends('layouts.app_admin', ['title' => 'Video Materi']) 
@section('content')

{{-- CSS TIDAK DIUBAH (SESUAI REQUEST AWAL) --}}
<style>
    .unggah { margin-bottom: 5px; display: flex; justify-content: flex-end; color: white; border: none; border-radius: 6px; background-color: #ffd700; font-weight: 500 !important; align-items: center; width: 102px; height: 30px; }
    .unggah i { color: white; font-size: 25px !important; padding-left: 5px; line-height: 0; vertical-align: middle; display: inline-block; }
    .search { width: 250px; position: relative; display: inline-block; }
    .search i { position: absolute; top: 50%; left: 8px; transform: translateY(-50%); color: #6c757d; font-size: 0.9rem; z-index: 2; }
    .search input.form-control { padding-left: 30px; height: 30px; }
    /* Tambahan Layout Grid agar rapi */
    .video-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
    .video-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
    .video-thumb { background: #000; height: 180px; display: flex; align-items: center; justify-content: center; color: white; overflow: hidden;}
    .video-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .video-info { padding: 15px; }
    .video-info p { margin-bottom: 5px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    {{-- FORM SEARCH --}}
    <form action="{{ route('admin_Video_Materi') }}" method="GET">
        <div class="search">
            <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm search-input" placeholder="Cari..." aria-label="Search" />
            <i class="bi bi-search"></i>
        </div>
    </form>

    <button class="unggah text-center" data-bs-toggle="modal" data-bs-target="#modalTambahVideo">
        Unggah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="video-grid">
    @foreach($videos as $v)
    <div class="video-card">
        <div class="video-thumb">
            {{-- Menampilkan Gambar Youtube (Otomatis) --}}
            @if($v->youtube_id)
                <img src="https://img.youtube.com/vi/{{ $v->youtube_id }}/hqdefault.jpg">
            @else
                GAMBAR
            @endif
        </div>
        <div class="video-info">
            {{-- DATA DARI DATABASE --}}
            <p><strong>Judul :</strong> {{ $v->nama_materi }}</p>
            <p><strong>Link Youtube :</strong> <a href="{{ $v->link_video }}" target="_blank">Buka Link</a></p>
            <p><strong>Mapel :</strong> {{ $v->mapel->nama_mapel ?? '-' }}</p>
            <p><strong>Siswa :</strong> {{ $v->siswa->nama ?? '-' }}</p>

            {{-- TOMBOL UBAH (MENGGANTIKAN DELETE) --}}
            <div class="mt-3">
                <button class="btn btn-warning btn-sm w-100 text-white" data-bs-toggle="modal" data-bs-target="#modalUbah{{ $v->id }}">
                    Ubah <i class="bi bi-pencil-square"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUbah{{ $v->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Video Materi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin_Video_Materi.update', $v->id) }}" method="POST">
                    @csrf
                    {{-- Tidak perlu method PUT jika route pakai POST, sesuaikan route --}}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Materi</label>
                            <input type="text" name="nama_materi" class="form-control" value="{{ $v->nama_materi }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Youtube</label>
                            <input type="url" name="link_video" class="form-control" value="{{ $v->link_video }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="id_mapel" class="form-select" required>
                                @foreach($dataMapel as $m)
                                    <option value="{{ $m->id }}" {{ $v->id_mapel == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select name="id_siswa" class="form-select" required>
                                @foreach($dataSiswa as $s)
                                    <option value="{{ $s->id }}" {{ $v->id_siswa == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kurikulum</label>
                            <select name="jenis_kurikulum" class="form-select" required>
                                <option value="Merdeka" {{ $v->jenis_kurikulum == 'Merdeka' ? 'selected' : '' }}>Merdeka</option>
                                <option value="K13" {{ $v->jenis_kurikulum == 'K13' ? 'selected' : '' }}>K13</option>
                                <option value="Cambridge" {{ $v->jenis_kurikulum == 'Cambridge' ? 'selected' : '' }}>Cambridge</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="pagination-wrapper d-flex justify-content-center mt-4">
    {{ $videos->links('pagination::bootstrap-4') }}
</div>

<div class="modal fade" id="modalTambahVideo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Video Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin_Video_Materi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Form Tambah Data --}}
                    <div class="mb-3">
                        <label>Nama Materi</label>
                        <input type="text" name="nama_materi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Link Video</label>
                        <input type="url" name="link_video" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mapel</label>
                        <select name="id_mapel" class="form-select" required>
                            <option value="">Pilih Mapel</option>
                            @foreach($dataMapel as $m) <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option> @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Siswa</label>
                        <select name="id_siswa" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($dataSiswa as $s) <option value="{{ $s->id }}">{{ $s->nama }}</option> @endforeach
                        </select>
                    </div>
                     <div class="mb-3">
                        <label>Kurikulum</label>
                        <select name="jenis_kurikulum" class="form-select" required>
                            <option value="Merdeka">Merdeka</option>
                            <option value="K13">K13</option>
                            <option value="Cambridge">Cambridge</option>
                        </select>
                    </div>
                    @if(Auth::user()->role == 'admin')
                    <div class="mb-3">
                        <label>Pilih Guru</label>
                        <select name="pilih_guru" class="form-select">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($dataGuru as $g) <option value="{{ $g->id }}">{{ $g->nama }}</option> @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app_guru', ['title' => 'Video Materi'])

@section('content')
    <div class="materi-search mb-4 d-flex justify-content-between align-items-center">
        <div class="search-input-wrapper">
            <i class="ri-search-line search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari">
        </div>

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
                    <p><strong>Link:</strong> <a href="{{ $v->link_video }}" target="_blank">{{ $v->link_video }}</a></p>
                    <p><strong>Kurikulum:</strong> {{ $v->jenis_kurikulum }}</p>
                </div>
                <div class="video-edit">
                    <button type="button" class="edit-icon" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $v->id }}">
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
                                    <input type="text" name="nama_materi" class="form-control" value="{{ $v->nama_materi }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Link Youtube</label>
                                    <input type="text" name="link_video" class="form-control" value="{{ $v->link_video }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kurikulum</label>
                                    <select name="jenis_kurikulum" class="form-control">
                                        <option value="K13" {{ $v->jenis_kurikulum == 'K13' ? 'selected' : '' }}>K13</option>
                                        <option value="Merdeka" {{ $v->jenis_kurikulum == 'Merdeka' ? 'selected' : '' }}>Merdeka</option>
                                    </select>
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
                        <div class="mb-3">
                            <label>Guru</label>
                            <select name="id_guru" class="form-control" required>
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Siswa (Opsional)</label>
                            <select name="id_siswa" class="form-control">
                                <option value="">-- Semua Siswa --</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Mata Pelajaran</label>
                            <select name="id_mapel" class="form-control" required>
                                @foreach ($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nama Materi</label>
                            <input type="text" name="nama_materi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Link Video</label>
                            <input type="text" name="link_video" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jenis Kurikulum</label>
                            <select name="jenis_kurikulum" class="form-control">
                                <option value="K13">K13</option>
                                <option value="Merdeka">Merdeka</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
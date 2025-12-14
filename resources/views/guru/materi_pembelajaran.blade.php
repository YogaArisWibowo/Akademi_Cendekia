@extends('layouts.app_guru', ['title' => 'Materi Pembelajaran'])

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="content-wrapper">

        <div class="materi-search mb-4 d-flex justify-content-between align-items-center">

            <div class="search-input-wrapper">
                <i class="ri-search-line search-icon"></i>
                <input type="text" class="search-input" placeholder="Cari">
            </div>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahMateri">
                + Tambah Materi
            </button>

        </div>

        <div class="modal fade" id="modalTambahMateri" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('store_materi') }}" method="POST">
                    @csrf
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Materi Pembelajaran</h5>
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
                                    <option value="">-- Pilih --</option>
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
                                <label>Materi</label>
                                <textarea name="materi" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Jenis Kurikulum</label>
                                <select name="jenis_kurikulum" class="form-control" required>
                                    <option value="K13">K13</option>
                                    <option value="Merdeka">Merdeka</option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="materi-grid">
            @foreach ($materi as $m)
                <a href="{{ route('detail_materi_pembelajaran', $m->id) }}" class="materi-card-link">
                    <div class="materi-card">
                        <div class="materi-thumb">
                            <img src="https://via.placeholder.com/150" alt="thumb">
                        </div>
                        <div class="materi-info">
                            <h4 class="materi-title">{{ $m->nama_materi }}</h4>
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

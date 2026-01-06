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

        <form action="{{ route('materi_pembelajaran') }}" method="GET" class="d-flex align-items-end mb-4">

            <div class="tahun-select-wrapper me-3">
                <label for="jenjang" class="form-label mb-1">Jenjang</label>
                <select name="jenjang" id="jenjang" class="form-select">
                    <option value="">Semua Jenjang</option>
                    @foreach ($jenjang as $j)
                        <option value="{{ $j }}" {{ request('jenjang') == $j ? 'selected' : '' }}>
                            {{ $j }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Filter
            </button>

        </form>

        <div class="modal fade" id="modalTambahMateri" tabindex="-1">
            <div class="modal-dialog">
                {{-- TAMBAHAN 1: enctype="multipart/form-data" AGAR BISA UPLOAD FILE --}}
                <form action="{{ route('store_materi') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Materi Pembelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            {{-- PERBAIKAN: Guru otomatis terisi (Readonly) agar tidak error ID --}}
                            <div class="mb-3">
                                <label>Guru</label>
                                <input type="hidden" name="id_guru" value="{{ $guruAsli->id }}">
                                <input type="text" class="form-control" value="{{ $guruAsli->nama }}" readonly
                                    style="background-color: #e9ecef;">
                            </div>

                            <div class="mb-3">
                                <label>Siswa </label>
                                <select name="id_siswa" class="form-control" required>
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

                            {{-- TAMBAHAN 2: INPUT FILE --}}
                            <div class="mb-3">
                                <label>Upload File (Opsional)</label>
                                <input type="file" name="file_materi" class="form-control">
                                <small class="text-muted">PDF/Word/Gambar (Max 5MB)</small>
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
        {{-- WRAPPER UTAMA: --}}
        {{-- Kita gunakan onclick JavaScript untuk link ke detail --}}
        {{-- Style cursor:pointer agar terlihat bisa diklik --}}
        <div class="materi-card-link" data-url="{{ route('detail_materi_pembelajaran', $m->id) }}" onclick="window.location=this.getAttribute('data-url')" style="cursor: pointer;">
            
            <div class="materi-card">
                {{-- 1. THUMBNAIL (Tanpa tag <a>) --}}
                <div class="materi-thumb">
                    @php $ext = pathinfo($m->file_materi, PATHINFO_EXTENSION); @endphp
                    @if($ext == 'pdf') <i class="bi bi-file-earmark-pdf text-danger"></i>
                    @elseif(in_array($ext, ['doc', 'docx'])) <i class="bi bi-file-earmark-word text-primary"></i>
                    @elseif(in_array($ext, ['ppt', 'pptx'])) <i class="bi bi-file-earmark-slides text-warning"></i>
                    @else <i class="bi bi-file-earmark-text"></i> @endif
                </div>

                <div class="materi-info">
                    {{-- 2. JUDUL (Tanpa tag <a>) --}}
                    <h4 class="materi-title">{{ $m->nama_materi }}</h4>
                    
                    {{-- 3. TOMBOL DOWNLOAD (Satu-satunya tag <a>) --}}
                    {{-- event.stopPropagation() penting agar saat klik download, tidak memicu link detail --}}
                    @if ($m->file_materi)
                        <div style="margin-top: auto; padding-top: 10px;">
                            <a href="{{ route('download_materi', $m->id) }}" 
                               class="btn btn-success btn-sm w-100"
                               onclick="event.stopPropagation();">
                                Download
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
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

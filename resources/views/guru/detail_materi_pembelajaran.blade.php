@extends('layouts.app_guru', ['title' => 'Detail Materi Pembelajaran'])

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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('materi_pembelajaran') }}" class="btn btn-warning">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                Edit Materi
            </button>
        </div>

        <h3 class="materi-detail-title">{{ $materi->nama_materi }}</h3>

        <div class="materi-detail-card">
            <p><strong>Ringkasan :</strong></p>
            <p>{{ $materi->materi }}</p>

            {{-- TAMBAHAN: Tombol Download (Hanya muncul jika ada file) --}}
            @if ($materi->file_materi)
                <div class="mt-4 border-top pt-3">
                    <p><strong>File Lampiran :</strong></p>
                    <a href="{{ route('download_materi', $materi->id) }}" class="btn btn-success btn-sm">
                        <i class="ri-download-line"></i> Download File
                    </a>
                    <small class="text-muted ms-2">{{ $materi->file_materi }}</small>
                </div>
            @endif
        </div>

        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                {{-- TAMBAHAN: enctype="multipart/form-data" WAJIB ADA --}}
                <form action="{{ route('update_materi', $materi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Materi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Nama Materi</label>
                                <input type="text" name="nama_materi" class="form-control"
                                    value="{{ $materi->nama_materi }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Materi</label>
                                <textarea name="materi" class="form-control" rows="5" required>{{ $materi->materi }}</textarea>
                            </div>

                            {{-- TAMBAHAN: Input untuk Ganti File --}}
                            <div class="mb-3">
                                <label>Ganti File (Opsional)</label>
                                <input type="file" name="file_materi" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
                            </div>

                            <div class="mb-3">
                                <label>Jenis Kurikulum</label>
                                <select name="jenis_kurikulum" class="form-control" required>
                                    <option value="K13" {{ $materi->jenis_kurikulum == 'K13' ? 'selected' : '' }}>K13
                                    </option>
                                    <option value="Merdeka" {{ $materi->jenis_kurikulum == 'Merdeka' ? 'selected' : '' }}>
                                        Merdeka</option>
                                </select>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Simpan Perubahan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

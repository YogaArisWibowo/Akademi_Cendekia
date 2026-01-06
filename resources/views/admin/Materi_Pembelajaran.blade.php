@extends('layouts.app_admin', ['title' => 'Materi Pembelajaran'])

@section('content')
<style>
    /* CSS SESUAI PERMINTAAN ANDA */
    .unggah { margin-bottom: 5px; display: flex; justify-content: flex-end; color: white; border: none; border-radius: 6px; background-color: #ffd700; font-weight: 500 !important; align-items: center; width: 102px; height: 30px; }
    .unggah i { color: white; font-size: 25px !important; padding-left: 5px; line-height: 0; vertical-align: middle; display: inline-block; }
    .search { width: 250px; position: relative; display: inline-block; }
    .search i { position: absolute; top: 50%; left: 8px; transform: translateY(-50%); color: #6c757d; font-size: 0.9rem; z-index: 2; }
    .search input.form-control { padding-left: 30px; height: 30px; }
    .materi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .materi-card-link { text-decoration: none; color: inherit; display: block; }
    .materi-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: transform 0.2s; border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; }
    .materi-card:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
    .materi-thumb { height: 120px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 40px; }
    .materi-info { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; }
    .materi-title { font-size: 16px; font-weight: 600; margin: 0 0 5px 0; color: #2d3748; }
    .materi-student { font-size: 13px; color: #6c757d; margin-top: auto; } /* Style untuk nama siswa */
    .pagination-wrapper { display: flex; gap: 5px; margin-top: 20px; }
    .btn.page { border: 1px solid #ddd; background: white; padding: 5px 10px; border-radius: 4px; }
    .btn.page.active { background-color: #0d6efd; color: white; border-color: #0d6efd; }
</style>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="search">
        <input type="search" id="searchInput" class="form-control form-control-sm search-input" placeholder="Cari..." aria-label="Search" />
        <i class="bi bi-search"></i>
    </div>
    <button class="unggah text-center" data-bs-toggle="modal" data-bs-target="#modalTambahMateri">
        Unggah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="materi-grid" id="materiGrid">
    @forelse($materi as $item)
    <a href="{{ route('admin_detail_materi_pembelajaran', $item->id) }}" class="materi-card-link materi-item">
        <div class="materi-card">
            <div class="materi-thumb">
                {{-- [PERBAIKAN] Mengambil extension dari file_materi, bukan materi --}}
                @php $ext = pathinfo($item->file_materi, PATHINFO_EXTENSION); @endphp
                @if($ext == 'pdf') <i class="bi bi-file-earmark-pdf text-danger"></i>
                @elseif(in_array($ext, ['doc', 'docx'])) <i class="bi bi-file-earmark-word text-primary"></i>
                @elseif(in_array($ext, ['ppt', 'pptx'])) <i class="bi bi-file-earmark-slides text-warning"></i>
                @else <i class="bi bi-file-earmark-text"></i> @endif
            </div>
            <div class="materi-info">
                <h4 class="materi-title">{{ $item->nama_materi }}</h4>
                
                <div class="materi-student">
                    <i class="bi bi-person-fill"></i> {{ $item->siswa->nama ?? 'Siswa Tidak Ditemukan' }}
                </div>
            </div>
        </div>
    </a>
    @empty
        <div class="text-center w-100 p-5" style="grid-column: 1 / -1;">
            <p class="text-muted">Belum ada materi yang diunggah.</p>
        </div>
    @endforelse
</div>

<div class="pagination-wrapper" id="paginationMateri"></div>

{{-- MODAL TAMBAH MATERI --}}
<div class="modal fade" id="modalTambahMateri" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin_Materi_Pembelajaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Materi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    @if(Auth::user()->role === 'admin')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Guru</label>
                        <select name="pilih_guru" class="form-select" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($dataGuru as $g)
                                <option value="{{ $g->id }}">{{ $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Nama Materi</label>
                        <input type="text" name="nama_materi" class="form-control" required placeholder="Contoh: Rumus Aljabar">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kurikulum</label>
                            <select name="jenis_kurikulum" class="form-select" required>
                                <option value="Merdeka">Merdeka</option>
                                <option value="K13">K13</option>
                                <option value="Ktsp">KTSP</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="id_mapel" class="form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($dataMapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Siswa Penerima</label>
                        <select name="id_siswa" class="form-select" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($dataSiswa as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }} - {{ $siswa->kelas ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- [PERBAIKAN] Menambahkan input Ringkasan agar bisa disimpan --}}
                    <div class="mb-3">
                        <label class="form-label">Ringkasan Materi</label>
                        <textarea name="materi" class="form-control" rows="3" placeholder="Masukkan ringkasan materi..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Materi</label>
                        <input type="file" name="file_materi" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #ffd700; border:none; color: white;">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Script Search & Pagination
    $(document).ready(function() {
        const rowsPerPage = 10;
        const $items = $("#materiGrid .materi-item");
        const $paginationContainer = $("#paginationMateri");
        let currentPage = 1;

        function showPage(page) {
            currentPage = page;
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            $items.hide().slice(start, end).fadeIn(300);
            renderButtons();
        }

        function renderButtons() {
            const totalRows = $items.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            $paginationContainer.empty();
            if (totalPages <= 1) return;
            $paginationContainer.append(`<button class="btn page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
            for (let i = 1; i <= totalPages; i++) {
                $paginationContainer.append(`<button class="btn page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
            }
            $paginationContainer.append(`<button class="btn page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
        }

        $(document).on("click", ".num", function() { showPage($(this).data("page")); });
        $(document).on("click", ".prev", function() { if (currentPage > 1) showPage(currentPage - 1); });
        $(document).on("click", ".next", function() { if (currentPage < Math.ceil($items.length / rowsPerPage)) showPage(currentPage + 1); });

        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            if (value.length > 0) {
                $paginationContainer.hide();
                $items.filter(function() { $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1) });
            } else {
                $paginationContainer.show();
                showPage(1);
            }
        });
        showPage(1);
    });
</script>
@endsection
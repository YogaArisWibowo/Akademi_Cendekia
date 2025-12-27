@extends('layouts.app_admin', ['title' => 'Data Guru & Siswa'])

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .swal2-container { z-index: 10000 !important; }
    
    .tambah { 
        margin-bottom: 10px; display: flex; justify-content: center; color: white !important; border: none; 
        border-radius: 8px; background-color: #ffd700; font-weight: 600 !important; 
        align-items: center; width: 120px; height: 38px; text-decoration: none; cursor: pointer; 
    }
    .data-section-title { font-weight: 600 !important; font-size: 28px; margin-bottom: 0; color: #1a1a1a; }
    .main-card { background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 40px; }
    
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }

    .custom-status-dropdown {
        border: 2px solid transparent !important; border-radius: 20px; padding: 5px 15px; 
        color: white !important; font-size: 11px; font-weight: 500; appearance: none; cursor: pointer;
        background-repeat: no-repeat; background-position: right 8px center; padding-right: 25px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    }
    .status-aktif { background-color: #52D669 !important; }
    .status-non-aktif { background-color: #FF7676 !important; }
    .form-control { border-radius: 10px; }

    /* Pagination Styling */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 20px;
    }
    .pagination-container {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .btn-page {
        border: 1px solid #e2e8f0;
        background: white;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        color: #4a5568;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-page.active {
        background-color: #ebf4ff;
        color: #3182ce;
        font-weight: 600;
        border-color: #3182ce;
    }
    .btn-page:disabled {
        cursor: default;
        background-color: #f7fafc;
        color: #cbd5e0;
        border-color: #edf2f7;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-2 px-3">
    <h2 class="data-section-title">Data Guru</h2>
    <button class="tambah" id="btn-tambah-guru">Tambah <i class="bi bi-plus"></i></button>
</div>
<div class="main-card">
    <div class="table-responsive">
        <table class="table-general" id="tableGuru">
            <thead>
                <tr>
                    <th>No</th><th>Nama</th><th>Mapel</th><th>No HP</th><th>Alamat</th><th>Pendidikan</th><th>E-Wallet</th><th>Rekening</th><th>Status</th><th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $g)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $g->nama }}</td>
                    <td>{{ $g->mapel }}</td>
                    <td>{{ $g->no_hp }}</td>
                    <td>{{ \Str::limit($g->alamat_guru, 15) }}</td>
                    <td>{{ $g->pendidikan_terakhir }}</td>
                    <td>{{ $g->jenis_e_wallet }} ({{ $g->no_e_wallet }})</td>
                    <td>{{ $g->rekening }}</td>
                    <td>
                        <select class="custom-status-dropdown select-status {{ strtolower($g->status_aktif) == 'aktif' ? 'status-aktif' : 'status-non-aktif' }}" data-id="{{ $g->id }}" data-tipe="guru">
                            <option value="aktif" {{ strtolower($g->status_aktif) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ strtolower($g->status_aktif) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btn-edit-guru" data-id="{{ $g->id }}"><i class="bi bi-pencil-square"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <div class="pagination-container" id="paginationGuru"></div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-2 px-3 mt-4">
    <h2 class="data-section-title">Data Siswa</h2>
    <button class="tambah" id="btn-tambah-siswa">Tambah <i class="bi bi-plus"></i></button>
</div>
<div class="main-card">
    <div class="table-responsive">
        <table class="table-general" id="tableSiswa">
            <thead>
                <tr>
                    <th>No</th><th>Nama</th><th>Jenjang</th><th>No HP</th><th>Alamat</th><th>Kelas</th><th>Asal Sekolah</th><th>Orang Tua</th><th>Status</th><th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->jenjang }}</td>
                    <td>{{ $s->no_hp }}</td>
                    <td>{{ \Str::limit($s->alamat, 15) }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td>{{ $s->asal_sekolah }}</td>
                    <td>{{ $s->nama_orang_tua }}</td>
                    <td>
                        <select class="custom-status-dropdown select-status {{ strtolower($s->status_aktif) == 'aktif' ? 'status-aktif' : 'status-non-aktif' }}" data-id="{{ $s->id }}" data-tipe="siswa">
                            <option value="aktif" {{ strtolower($s->status_aktif) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ strtolower($s->status_aktif) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary btn-edit-siswa" data-id="{{ $s->id }}"><i class="bi bi-pencil-square"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination-wrapper">
        <div class="pagination-container" id="paginationSiswa"></div>
    </div>
</div>

{{-- MODAL GURU & SISWA TETAP SAMA SEPERTI KODE SEBELUMNYA --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const dataGuru = JSON.parse('{!! json_encode($guru->keyBy("id")) !!}');
    const dataSiswa = JSON.parse('{!! json_encode($siswa->keyBy("id")) !!}');

    $(document).ready(function() {
        const mGuru = new bootstrap.Modal(document.getElementById('modalGuru'));
        const mSiswa = new bootstrap.Modal(document.getElementById('modalSiswa'));

        // --- LOGIKA PAGINATION DINAMIS ---
        function createPagination(tableId, paginationId) {
            const rowsPerPage = 10;
            let currentPage = 1;
            const $rows = $(`#${tableId} tbody tr`);
            
            function render() {
                const totalPages = Math.ceil($rows.length / rowsPerPage);
                const $container = $(`#${paginationId}`);
                $container.empty();

                if (totalPages > 1) {
                    $container.append(`<button class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                    for (let i = 1; i <= totalPages; i++) {
                        $container.append(`<button class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    $container.append(`<button class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
                }
                $rows.hide().slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();
            }

            $(document).on('click', `#${paginationId} .num`, function() { currentPage = parseInt($(this).data('page')); render(); });
            $(document).on('click', `#${paginationId} .prev`, function() { if (currentPage > 1) { currentPage--; render(); } });
            $(document).on('click', `#${paginationId} .next`, function() { if (currentPage < Math.ceil($rows.length / rowsPerPage)) { currentPage++; render(); } });

            render();
        }

        createPagination('tableGuru', 'paginationGuru');
        createPagination('tableSiswa', 'paginationSiswa');

        // ... Logika AJAX Status & Edit Modal (Jangan Ubah) ...
    });
</script>
@endsection
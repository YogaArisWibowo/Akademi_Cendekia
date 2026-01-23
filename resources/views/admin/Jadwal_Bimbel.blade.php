@extends('layouts.app_admin', ['title' => 'Jadwal Bimbel'])

@section('content')

{{-- ALERT ERROR --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    /* --- CSS TOMBOL UTAMA --- */
    .tambah {
        margin-bottom: 5px; display: flex; justify-content: center; color: white; border: none;
        border-radius: 6px; background-color: #ffd700; font-weight: 500 !important;
        align-items: center; width: 110px; height: 35px; cursor: pointer; text-decoration: none;
        transition: 0.3s;
    }
    .tambah:hover { background-color: #e6c200; color: white; }
    .tambah i { font-size: 25px; padding-left: 5px; }
    
    .data-title { font-weight: 600 !important; font-size: 30px; padding-left: 15px; }
    
    /* --- CSS TABEL --- */
    .table-container {
        width: 100%; overflow-x: auto; background: white; padding: 15px;
        border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }
    
    /* --- CSS SEARCH --- */
    .search { width: 250px; position: relative; display: inline-block; }
    .search i { position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #6c757d; }
    .search input.form-control { padding-left: 35px; height: 35px; border-radius: 6px; }

    /* --- CSS PAGINATION (Gaya Baru) --- */
    .pagination-container {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }
    
    .btn-page {
        border: 1px solid #dee2e6;
        background-color: white;
        color: #0d6efd;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
    }
    
    .btn-page:hover:not(:disabled) {
        background-color: #e9ecef;
    }
    
    .btn-page.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    
    .btn-page:disabled {
        color: #6c757d;
        background-color: #f8f9fa;
        border-color: #dee2e6;
        cursor: default;
    }
</style>

{{-- HEADER HALAMAN --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <p class="data-title">Jadwal Bimbel</p>
        <div class="search">
            <input type="search" id="searchInput" class="form-control" placeholder="Cari jadwal..." />
            <i class="bi bi-search"></i>
        </div>
    </div>
    <button class="tambah" id="btn-tambah-jadwal">
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

{{-- TABEL DATA --}}
<div class="table-container">
    <table class="table-general" id="jadwalTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mapel</th>
                <th>Guru</th>
                <th>Siswa</th>
                <th>Alamat</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="jadwalTbody">
            @foreach($jadwal as $j)
            <tr class="jadwal-item">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $j->hari }}</td>
                <td class="text-uppercase">{{ \Carbon\Carbon::parse($j->created_at)->format('j-M-Y') }}</td>
                <td>{{ substr($j->waktu_mulai, 0, 5) }} - {{ substr($j->waktu_selesai, 0, 5) }}</td>
                <td>{{ $j->mapel->nama_mapel ?? $j->nama_mapel }}</td>
                <td>{{ $j->guru->nama ?? '-' }}</td>
                <td>{{ $j->siswa->nama ?? '-' }}</td>
                <td>{{ $j->alamat_siswa }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-sm btn-info btn-edit-jadwal" data-id="{{ $j->id }}">
                            <i class="bi bi-pencil-square text-white"></i>
                        </button>
                        <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="form-hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach

            {{-- Baris Pesan Jika Data Kosong (Hidden by default) --}}
            <tr id="noDataRow" style="display: none;">
                <td colspan="9" class="text-center py-5 text-muted">
                    <i class="bi bi-emoji-frown display-6 mb-3 d-block"></i>
                    Data jadwal tidak ditemukan.
                </td>
            </tr>
        </tbody>
    </table>

    {{-- CONTAINER PAGINATION --}}
    <div class="pagination-container" id="paginationControls"></div>
</div>

{{-- MODAL TAMBAH/EDIT --}}
<div class="modal fade" id="modalJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formJadwal" method="POST">
            @csrf
            <div id="methodJadwal"></div>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" name="created_at" id="j_created_at" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hari</label>
                                <input type="text" name="hari" id="j_hari" class="form-control" readonly style="background-color: #f8f9fa" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" name="waktu_mulai" id="j_mulai" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" name="waktu_selesai" id="j_selesai" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Guru</label>
                                <select name="id_guru" id="j_id_guru" class="form-control" required>
                                    <option value="" data-mapel="">-- Pilih Guru --</option>
                                    @foreach($guru as $g)
                                    <option value="{{ $g->id }}" data-mapel="{{ $g->mapel }}">{{ $g->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="id_mapel" id="j_id_mapel" class="form-control" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach($mapel as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="nama_mapel" id="j_nama_mapel" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Siswa</label>
                                <select name="id_siswa" id="j_id_siswa" class="form-control" required>
                                    <option value="" data-alamat="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $s)
                                    <option value="{{ $s->id }}" data-alamat="{{ $s->alamat }}">{{ $s->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Siswa</label>
                                <input type="text" name="alamat_siswa" id="j_alamat" class="form-control" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const dataJadwal = JSON.parse('{!! addslashes(json_encode($jadwal->keyBy("id"))) !!}');

    $(document).ready(function () {
        
        // --- LOGIKA PAGINATION & SEARCH (Gaya Baru) ---
        function setupTablePagination(tableId, paginationId, searchId) {
            const rowsPerPage = 10; 
            let currentPage = 1;
            
            const $table = $('#' + tableId);
            const $pagination = $('#' + paginationId);
            const $searchInput = $('#' + searchId);
            const $noDataRow = $('#noDataRow');
            
            const $allRows = $table.find('tbody tr.jadwal-item');
            
            function render() {
                const searchValue = $searchInput.val().toLowerCase();
                
                // 1. Filter baris berdasarkan Search
                const $visibleRows = $allRows.filter(function() {
                    const text = $(this).text().toLowerCase();
                    return text.indexOf(searchValue) > -1;
                });

                // 2. Hitung total halaman
                const totalItems = $visibleRows.length;
                const totalPages = Math.ceil(totalItems / rowsPerPage);
                
                // Reset page jika hasil filter lebih sedikit dari posisi saat ini
                if (currentPage > totalPages) currentPage = 1;
                if (currentPage < 1) currentPage = 1;

                // 3. Tampilkan/Sembunyikan Baris
                $allRows.hide(); // Sembunyikan semua dulu
                $noDataRow.hide(); 

                if (totalItems === 0) {
                    $noDataRow.show(); // Munculkan pesan kosong
                    $pagination.empty();
                    return;
                }

                // Slice data yang visible sesuai halaman
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                $visibleRows.slice(start, end).show();

                // 4. Render Tombol Pagination
                $pagination.empty();
                
                if (totalPages > 1) {
                    // Tombol Previous
                    $pagination.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                    
                    // Tombol Angka
                    for (let i = 1; i <= totalPages; i++) {
                        $pagination.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    
                    // Tombol Next
                    $pagination.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
                }
            }

            // Event Listeners Pagination
            $pagination.on('click', '.num', function() { 
                currentPage = $(this).data('page'); 
                render(); 
            });
            
            $pagination.on('click', '.prev', function() { 
                if (currentPage > 1) { currentPage--; render(); } 
            });
            
            $pagination.on('click', '.next', function() { 
                // Hitung ulang total pages saat klik next (karena search dinamis)
                const currentFilteredCount = $allRows.filter(function() {
                    return $(this).text().toLowerCase().indexOf($searchInput.val().toLowerCase()) > -1;
                }).length;
                
                if (currentPage < Math.ceil(currentFilteredCount / rowsPerPage)) { 
                    currentPage++; 
                    render(); 
                } 
            });

            // Event Search: Reset ke halaman 1 setiap mengetik
            $searchInput.on('keyup', function() {
                currentPage = 1;
                render();
            });

            // Render pertama kali saat load
            render();
        }

        // Jalankan Fungsi Pagination
        setupTablePagination('jadwalTable', 'paginationControls', 'searchInput');


        // --- LOGIKA FORM MODAL (Add/Edit) ---
        const mJadwal = new bootstrap.Modal(document.getElementById("modalJadwal"));

        // 1. Auto-fill Mapel saat Guru dipilih
        $("#j_id_guru").on("change", function () {
            const selectedGuruMapel = $(this).find("option:selected").data("mapel");
            if (selectedGuruMapel) {
                $("#j_id_mapel option").each(function () {
                    if ($(this).text() === selectedGuruMapel) {
                        $(this).prop("selected", true);
                        $("#j_nama_mapel").val(selectedGuruMapel);
                        return false; 
                    }
                });
            }
        });
        
        // 2. Auto-fill Alamat saat Siswa dipilih
        $("#j_id_siswa").on("change", function () {
            const alamat = $(this).find("option:selected").data("alamat");
            $("#j_alamat").val(alamat || "");
        });

        // 3. Auto-fill Hari saat Tanggal dipilih
        $("#j_created_at").on("change", function () {
            if ($(this).val()) {
                const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                $("#j_hari").val(days[new Date($(this).val()).getDay()]);
            }
        });

        // 4. [BARU] VALIDASI WAKTU (Mulai vs Selesai)
        // Fungsi cek waktu
        function checkTimeValidity() {
            var startTime = $('#j_mulai').val();
            var endTime = $('#j_selesai').val();

            if (startTime && endTime) {
                if (endTime <= startTime) {
                    alert("Waktu Selesai harus lebih besar dari Waktu Mulai!");
                    $('#j_selesai').val(''); // Reset input selesai
                }
            }
        }

        // Cek saat input berubah
        $('#j_mulai, #j_selesai').on('change', function() {
            checkTimeValidity();
        });

        // Cek juga saat form disubmit (Pengaman Ganda)
        $('#formJadwal').on('submit', function(e) {
            var startTime = $('#j_mulai').val();
            var endTime = $('#j_selesai').val();
            if (startTime && endTime && endTime <= startTime) {
                e.preventDefault(); 
                alert("Mohon perbaiki Waktu Selesai sebelum menyimpan!");
            }
        });

        // 5. Tombol Tambah
        $("#btn-tambah-jadwal").on("click", function () {
            $("#modalJadwal .modal-title").text("Tambah Jadwal");
            $("#formJadwal").attr("action", "{{ route('jadwal.store') }}");
            $("#methodJadwal").empty(); // Hapus method PUT (reset ke POST)
            $("#formJadwal")[0].reset();
            $("#j_nama_mapel").val("");
            mJadwal.show();
        });

        // 6. Tombol Edit
        $(document).on("click", ".btn-edit-jadwal", function () {
            const id = $(this).data("id");
            const data = dataJadwal[id];
            
            $("#modalJadwal .modal-title").text("Edit Jadwal");
            // Sesuaikan route update Anda, pastikan sesuai web.php
            $("#formJadwal").attr("action", "{{ url('admin/admin_jadwal_bimbel/update') }}/" + id);
            $("#methodJadwal").html('<input type="hidden" name="_method" value="PUT">');
            
            // Isi Form
            $("#j_created_at").val(data.created_at ? data.created_at.split(" ")[0] : "");
            $("#j_hari").val(data.hari);
            $("#j_mulai").val(data.waktu_mulai);
            $("#j_selesai").val(data.waktu_selesai);
            
            $("#j_id_mapel").val(data.id_mapel);
            $("#j_nama_mapel").val(data.nama_mapel);
            $("#j_id_guru").val(data.id_guru);
            $("#j_id_siswa").val(data.id_siswa);
            $("#j_alamat").val(data.alamat_siswa);
            
            mJadwal.show();
        });
    });
</script>
@endsection
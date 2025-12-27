@extends('layouts.app_admin', ['title' => 'Jadwal Bimbel']) 

@section('content')
<style>
    .tambah {
        margin-bottom: 5px; display: flex; justify-content: center; color: white; border: none;
        border-radius: 6px; background-color: #ffd700; font-weight: 500 !important;
        align-items: center; width: 110px; height: 35px; cursor: pointer; text-decoration: none;
    }
    .tambah i { font-size: 25px; padding-left: 5px; }
    .data-title { font-weight: 600 !important; font-size: 30px; padding-left: 15px; }
    
    .table-container {
        width: 100%; overflow-x: auto; background: white; padding: 15px;
        border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .table-general { width: 100%; min-width: 1000px; border-collapse: collapse; }
    .table-general th, .table-general td { padding: 12px 15px; border-bottom: 1px solid #eee; }
    
    .search { width: 250px; position: relative; display: inline-block; }
    .search i { position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #6c757d; }
    .search input.form-control { padding-left: 35px; height: 35px; border-radius: 6px; }

    /* Pagination Styling Tengah */
    .pagination-wrapper { display: flex; justify-content: center; width: 100%; margin-top: 20px; }
    .pagination-container { display: flex; gap: 8px; justify-content: center; }
    .btn-page {
        border: 1px solid #e2e8f0; background: white; padding: 6px 14px;
        border-radius: 8px; font-size: 13px; color: #4a5568; cursor: pointer; transition: 0.3s;
    }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; border-color: #3182ce; }
    .btn-page:disabled { cursor: default; background-color: #f7fafc; color: #cbd5e0; border-color: #edf2f7; }
</style>

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
        <tbody>
            @foreach($jadwal as $j)
            <tr>
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
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination-wrapper">
        <div class="pagination-container" id="paginationControls"></div>
    </div>
</div>

{{-- MODAL FORM --}}
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
                                <label class="form-label">Guru</label>
                                <select name="id_guru" id="j_id_guru" class="form-control" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Siswa</label>
                                <select name="id_siswa" id="j_id_siswa" class="form-control" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const dataJadwal = JSON.parse('{!! addslashes(json_encode($jadwal->keyBy("id"))) !!}');

    $(document).ready(function () {
        const mJadwal = new bootstrap.Modal(document.getElementById("modalJadwal"));

        // --- LOGIKA PAGINATION ---
        const rowsPerPage = 10;
        let currentPage = 1;

        function renderPagination() {
            const $rows = $("#jadwalTable tbody tr:visible");
            const totalRows = $rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const $controls = $("#paginationControls");

            $controls.empty();
            if (totalPages > 1) {
                $controls.append(`<button class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}>Sebelumnya</button>`);
                for (let i = 1; i <= totalPages; i++) {
                    $controls.append(`<button class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                }
                $controls.append(`<button class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}>Selanjutnya</button>`);
            }
            $rows.hide().slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();
        }

        $(document).on("click", ".num", function () { currentPage = parseInt($(this).data("page")); renderPagination(); });
        $(document).on("click", ".prev", function () { if (currentPage > 1) { currentPage--; renderPagination(); } });
        $(document).on("click", ".next", function () { if (currentPage < Math.ceil($("#jadwalTable tbody tr:visible").length / rowsPerPage)) { currentPage++; renderPagination(); } });

        renderPagination();

        // --- SEARCH ---
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#jadwalTable tbody tr").each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
            currentPage = 1;
            renderPagination();
        });

        // --- KONFIRMASI HAPUS ---
        $(document).on("submit", ".form-hapus", function (e) {
            if (!confirm("Yakin ingin menghapus jadwal ini?")) {
                e.preventDefault();
            }
        });

        // --- TOMBOL TAMBAH ---
        $("#btn-tambah-jadwal").on("click", function () {
            $("#modalJadwal .modal-title").text("Tambah Jadwal");
            $("#formJadwal").attr("action", "{{ route('jadwal.store') }}");
            $("#methodJadwal").empty();
            $("#formJadwal")[0].reset();
            mJadwal.show();
        });

        // --- TOMBOL EDIT ---
        $(".btn-edit-jadwal").on("click", function () {
            const id = $(this).data("id");
            const data = dataJadwal[id];
            
            $("#modalJadwal .modal-title").text("Edit Jadwal");
            $("#formJadwal").attr("action", "/admin/admin_jadwal_bimbel/update/" + id);
            $("#methodJadwal").html('<input type="hidden" name="_method" value="PUT">');
            
            // Format tanggal untuk input date
            let dateStr = data.created_at.split("T")[0].split(" ")[0];
            
            $("#j_created_at").val(dateStr);
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

        // OTOMATIS HARI
        $("#j_created_at").on("change", function () {
            const date = new Date($(this).val());
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            $("#j_hari").val(days[date.getDay()]);
        });
    });
</script>
@endsection
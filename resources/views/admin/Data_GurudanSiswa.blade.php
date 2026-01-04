@extends('layouts.app_admin', ['title' => 'Data Guru & Siswa'])

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- STYLING TAMBAHAN --- */
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
    
    .pagination-wrapper { display: flex; justify-content: center; width: 100%; margin-top: 20px; }
    .pagination-container { display: flex; gap: 8px; justify-content: center; }
    .btn-page { border: 1px solid #e2e8f0; background: white; padding: 6px 14px; border-radius: 8px; font-size: 13px; cursor: pointer; }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; border-color: #3182ce; }
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
                    <th>No</th><th>Nama</th><th>Mapel</th><th>No HP</th><th>Alamat</th><th>Status</th><th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $g)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $g->nama }}</td>
                    <td>{{ $g->mapel }}</td>
                    <td>{{ $g->no_hp }}</td>
                    <td>{{ \Str::limit($g->alamat_guru, 20) }}</td>
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
                    <th>No</th><th>Nama</th><th>Jenjang</th><th>No HP</th><th>Kelas</th><th>Status</th><th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->jenjang }}</td>
                    <td>{{ $s->no_hp }}</td>
                    <td>{{ $s->kelas }}</td>
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

<div class="modal fade" id="modalGuru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formGuru">
            @csrf
            <input type="hidden" name="id" id="g_id">
            <input type="hidden" name="_method" id="g_method" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleGuru">Form Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" id="g_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mapel" id="g_mapel" class="form-control form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapel as $m)
                                    <option value="{{ $m->nama_mapel }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No HP (WhatsApp)</label>
                            <input type="text" name="no_hp" id="g_no_hp" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" id="g_pendidikan" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat_guru" id="g_alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Jenis E-Wallet</label>
                            <input type="text" name="jenis_e_wallet" id="g_wallet_tipe" class="form-control" placeholder="Dana/OVO/dll">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>No E-Wallet</label>
                            <input type="text" name="no_e_wallet" id="g_wallet_no" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Rekening Bank</label>
                            <input type="text" name="rekening" id="g_rekening" class="form-control" placeholder="BCA - 123456">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanGuru">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formSiswa">
            @csrf
            <input type="hidden" name="id" id="s_id">
            <input type="hidden" name="_method" id="s_method" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleSiswa">Form Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama" id="s_nama" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenjang</label>
                            <select name="jenjang" id="s_jenjang" class="form-control form-select">
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kelas</label>
                            <input type="text" name="kelas" id="s_kelas" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" id="s_no_hp" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" id="s_asal_sekolah" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Orang Tua</label>
                            <input type="text" name="nama_orang_tua" id="s_ortu" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" id="s_alamat" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanSiswa">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // --- SETUP CSRF & DATA ---
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Mengambil data lengkap dari Controller (keyBy id agar mudah dipanggil)
    const dataGuru = JSON.parse('{!! addslashes(json_encode($guru->keyBy("id"))) !!}');
    const dataSiswa = JSON.parse('{!! addslashes(json_encode($siswa->keyBy("id"))) !!}');

    $(document).ready(function() {
        const mGuru = new bootstrap.Modal(document.getElementById('modalGuru'));
        const mSiswa = new bootstrap.Modal(document.getElementById('modalSiswa'));

        // --- CLIENT SIDE PAGINATION (Simple) ---
        function setupPagination(tableId, paginationId) {
            const rowsPerPage = 10;
            let currentPage = 1;
            const $table = $(`#${tableId}`);
            
            function render() {
                const $rows = $table.find('tbody tr');
                const totalRows = $rows.length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                const $container = $(`#${paginationId}`);
                
                $container.empty();
                if (totalPages > 1) {
                    $container.append(`<button type="button" class="btn-page prev" ${currentPage === 1 ? 'disabled' : ''}><i class="bi bi-chevron-left"></i></button>`);
                    for (let i = 1; i <= totalPages; i++) {
                        $container.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }
                    $container.append(`<button type="button" class="btn-page next" ${currentPage === totalPages ? 'disabled' : ''}><i class="bi bi-chevron-right"></i></button>`);
                }
                $rows.hide().slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();
            }

            $(document).on('click', `#${paginationId} .num`, function() { currentPage = $(this).data('page'); render(); });
            $(document).on('click', `#${paginationId} .prev`, function() { if (currentPage > 1) { currentPage--; render(); } });
            $(document).on('click', `#${paginationId} .next`, function() { if (currentPage < 100) { currentPage++; render(); } });
            render();
        }

        setupPagination('tableGuru', 'paginationGuru');
        setupPagination('tableSiswa', 'paginationSiswa');

        // ==========================================
        // LOGIKA GURU (CRUD)
        // ==========================================
        $('#btn-tambah-guru').click(function() {
            $('#titleGuru').text('Tambah Data Guru');
            $('#formGuru')[0].reset();
            $('#g_id').val('');
            $('#g_method').val('POST');
            $('#g_mapel').val('').change();
            mGuru.show();
        });

        $(document).on('click', '.btn-edit-guru', function() {
            const id = $(this).data('id');
            const g = dataGuru[id];
            
            $('#titleGuru').text('Edit Data Guru');
            $('#formGuru')[0].reset();
            $('#g_id').val(g.id);
            $('#g_method').val('PUT');
            
            $('#g_nama').val(g.nama);
            $('#g_mapel').val(g.mapel).change(); 
            $('#g_no_hp').val(g.no_hp);
            $('#g_pendidikan').val(g.pendidikan_terakhir);
            $('#g_alamat').val(g.alamat_guru);
            $('#g_wallet_tipe').val(g.jenis_e_wallet);
            $('#g_wallet_no').val(g.no_e_wallet);
            $('#g_rekening').val(g.rekening);
            
            mGuru.show();
        });

        $('#formGuru').submit(function(e) {
            e.preventDefault();
            let id = $('#g_id').val();
            let url = id ? ('/admin/guru/update/' + id) : '/admin/guru/store';
            
            $('#btnSimpanGuru').text('Menyimpan...').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    mGuru.hide();
                    Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
                },
                error: function(xhr) {
                    $('#btnSimpanGuru').text('Simpan Data').prop('disabled', false);
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi Kesalahan';
                    Swal.fire('Gagal!', msg, 'error');
                }
            });
        });

        // ==========================================
        // LOGIKA SISWA (CRUD) - DENGAN FIX JENJANG
        // ==========================================
        $('#btn-tambah-siswa').click(function() {
            $('#titleSiswa').text('Tambah Data Siswa');
            $('#formSiswa')[0].reset();
            $('#s_id').val('');
            $('#s_method').val('POST');
            $('#s_jenjang').val('').change();
            mSiswa.show();
        });

        $(document).on('click', '.btn-edit-siswa', function() {
            const id = $(this).data('id');
            const s = dataSiswa[id];
            
            // --- DEBUGGING: Cek Console Browser (Tekan F12) jika masih error ---
            console.log("Data Siswa dari DB:", s);
            console.log("Jenjang Asli:", s.jenjang);
            
            $('#titleSiswa').text('Edit Data Siswa');
            $('#formSiswa')[0].reset();
            $('#s_id').val(s.id);
            $('#s_method').val('PUT');
            
            $('#s_nama').val(s.nama);
            
            // --- FIX PENGAMBILAN DATA JENJANG ---
            if (s.jenjang) {
                // Konversi ke String, Huruf Besar, dan Hapus Spasi (misal: " sd " -> "SD")
                let jenjangFix = String(s.jenjang).toUpperCase().trim();
                $('#s_jenjang').val(jenjangFix);
                
                // Jika setelah diset masih kosong (berarti data DB "Sekolah Dasar" tidak cocok dgn "SD")
                if (!$('#s_jenjang').val()) {
                     console.warn("Data jenjang di DB ('"+ s.jenjang +"') tidak cocok dengan opsi Dropdown.");
                }
            } else {
                $('#s_jenjang').val('');
            }
            // Trigger change agar tampilan dropdown update
            $('#s_jenjang').trigger('change');
            // ------------------------------------

            $('#s_kelas').val(s.kelas);
            $('#s_no_hp').val(s.no_hp);
            $('#s_asal_sekolah').val(s.asal_sekolah);
            $('#s_ortu').val(s.nama_orang_tua);
            $('#s_alamat').val(s.alamat);
            
            mSiswa.show();
        });

        $('#formSiswa').submit(function(e) {
            e.preventDefault();
            let id = $('#s_id').val();
            let url = id ? ('/admin/siswa/update/' + id) : '/admin/siswa/store';
            
            $('#btnSimpanSiswa').text('Menyimpan...').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    mSiswa.hide();
                    Swal.fire('Berhasil!', res.message, 'success').then(() => location.reload());
                },
                error: function(xhr) {
                    $('#btnSimpanSiswa').text('Simpan Data').prop('disabled', false);
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi Kesalahan';
                    Swal.fire('Gagal!', msg, 'error');
                }
            });
        });

        // --- UPDATE STATUS (GLOBAL) ---
        $('.select-status').change(function() {
            let id = $(this).data('id');
            let tipe = $(this).data('tipe'); 
            let status = $(this).val();
            let $select = $(this);

            if(status === 'aktif') $select.removeClass('status-non-aktif').addClass('status-aktif');
            else $select.removeClass('status-aktif').addClass('status-non-aktif');

            $.ajax({
                url: `/admin/${tipe}/update-status/${id}`,
                type: 'POST',
                data: { status_aktif: status, _method: 'PUT' },
                success: function() {
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    Toast.fire({ icon: 'success', title: 'Status diperbarui' });
                },
                error: function() {
                    Swal.fire('Error', 'Gagal update status', 'error');
                }
            });
        });
    });
</script>
@endsection
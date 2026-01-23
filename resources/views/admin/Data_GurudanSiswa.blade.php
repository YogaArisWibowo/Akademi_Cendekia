@extends('layouts.app_admin', ['title' => 'Data Guru & Siswa'])
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

{{-- HAPUS SCRIPT SWEETALERT --}}
{{--
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
--}}

<style>
    /* --- STYLING GLOBAL --- */
    /* Hapus class .swal2-container */

    /* Card Utama */
    .main-card {
        background: white;
        padding: 30px;
        border-radius: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
    }

    /* ... (SISA CSS LAINNYA TETAP SAMA SEPERTI SEBELUMNYA) ... */

    /* Judul Halaman */
    .data-section-title {
        font-weight: 600 !important;
        font-size: 28px;
        margin-bottom: 0;
        color: #1a1a1a;
    }

    /* Tombol Tambah */
    .tambah {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        color: white !important;
        border: none;
        border-radius: 8px;
        background-color: #ffd700;
        font-weight: 600 !important;
        width: 120px;
        height: 38px;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s;
        font-size: 14px;
    }
    .tambah:hover {
        background-color: #e6c200;
        color: white;
    }

    /* Tabel Custom */
    .table-general {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 10px;
    }
    .table-general thead th {
        background-color: #cce0ff !important;
        color: #333;
        padding: 12px 15px;
        border: none;
        font-size: 14px;
        white-space: nowrap;
    }
    .table-general tbody td {
        padding: 12px 15px;
        border: none;
        vertical-align: middle;
        font-size: 14px;
        white-space: nowrap;
    }
    .table-general tbody tr:nth-child(even) {
        background-color: #ebf3ff;
    }

    /* Dropdown Status */
    .custom-status-dropdown {
        border: 2px solid transparent !important;
        border-radius: 20px;
        padding: 5px 15px;
        color: white !important;
        font-size: 12px;
        font-weight: 500;
        appearance: none;
        cursor: pointer;
        background-repeat: no-repeat;
        background-position: right 8px center;
        padding-right: 30px;
        min-width: 110px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    }
    .status-aktif {
        background-color: #52d669 !important;
    }
    .status-non-aktif {
        background-color: #ff7676 !important;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 20px;
    }
    .pagination-container {
        display: flex;
        gap: 5px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .btn-page {
        border: 1px solid #e2e8f0;
        background: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-page:hover {
        background-color: #f7fafc;
    }
    .btn-page.active {
        background-color: #ebf4ff;
        color: #3182ce;
        font-weight: 600;
        border-color: #3182ce;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 10px;
        }
        .data-section-title {
            font-size: 20px !important;
        }
        .tambah {
            width: auto !important;
            padding: 5px 15px;
            height: 32px;
            font-size: 12px !important;
        }
        .main-card {
            padding: 15px;
        }
        .table-general thead th,
        .table-general tbody td {
            font-size: 12px;
            padding: 8px;
        }
    }
</style>

{{-- HTML BODY (Tabel & Modal) TETAP SAMA, TIDAK ADA PERUBAHAN DI SINI --}}
{{-- Langsung copy-paste bagian HTML Body dari kode sebelumnya di sini --}}
<div
    class="d-flex justify-content-between align-items-center mb-3 px-1 header-section"
>
    <h2 class="data-section-title">Data Guru</h2>
    <button class="tambah" id="btn-tambah-guru">
        Tambah <i class="bi bi-plus fs-5 ms-1"></i>
    </button>
</div>
{{-- ... dst (HTML Tabel Guru, Siswa, dan Modal sama persis) ... --}}
{{-- Untuk menghemat tempat, pastikan Anda menyertakan kembali seluruh HTML Tabel dan Modal di sini --}}
{{-- ... --}}

<div class="main-card">
    <div class="table-responsive">
        <table class="table-general" id="tableGuru">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Mapel</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $g)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $g->nama }}</td>
                    <td>{{ $g->mapel }}</td>
                    <td>{{ $g->no_hp }}</td>
                    <td title="{{ $g->alamat_guru }}">
                        {{ \Str::limit($g->alamat_guru, 20) }}
                    </td>
                    <td>
                        <select
                            class="custom-status-dropdown select-status {{ strtolower($g->status_aktif) == 'aktif' ? 'status-aktif' : 'status-non-aktif' }}"
                            data-id="{{ $g->id }}"
                            data-tipe="guru"
                        >
                            <option value="aktif" {{ strtolower($g->
                                status_aktif) == 'aktif' ? 'selected' : ''
                                }}>Aktif
                            </option>
                            <option value="non-aktif" {{ strtolower($g->
                                status_aktif) == 'non-aktif' ? 'selected' : ''
                                }}>Non-Aktif
                            </option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-primary btn-edit-guru"
                            data-id="{{ $g->id }}"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </button>
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

<div
    class="d-flex justify-content-between align-items-center mb-3 px-1 header-section mt-5"
>
    <h2 class="data-section-title">Data Siswa</h2>
    <button class="tambah" id="btn-tambah-siswa">
        Tambah <i class="bi bi-plus fs-5 ms-1"></i>
    </button>
</div>

<div class="main-card">
    <div class="table-responsive">
        <table class="table-general" id="tableSiswa">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenjang</th>
                    <th>No HP</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
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
                        <select
                            class="custom-status-dropdown select-status {{ strtolower($s->status_aktif) == 'aktif' ? 'status-aktif' : 'status-non-aktif' }}"
                            data-id="{{ $s->id }}"
                            data-tipe="siswa"
                        >
                            <option value="aktif" {{ strtolower($s->
                                status_aktif) == 'aktif' ? 'selected' : ''
                                }}>Aktif
                            </option>
                            <option value="non-aktif" {{ strtolower($s->
                                status_aktif) == 'non-aktif' ? 'selected' : ''
                                }}>Non-Aktif
                            </option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button
                            class="btn btn-sm btn-primary btn-edit-siswa"
                            data-id="{{ $s->id }}"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </button>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form id="formGuru">
            @csrf <input type="hidden" name="id" id="g_id" />
            <input type="hidden" name="_method" id="g_method" value="POST" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleGuru">Form Guru</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input
                                type="text"
                                name="nama"
                                id="g_nama"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select
                                name="mapel"
                                id="g_mapel"
                                class="form-control form-select"
                                required
                            >
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapel as $m)
                                <option value="{{ $m->nama_mapel }}">
                                    {{ $m->nama_mapel }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP (WhatsApp)</label>
                            <input
                                type="text"
                                name="no_hp"
                                id="g_no_hp"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"
                                >Pendidikan Terakhir</label
                            >
                            <input
                                type="text"
                                name="pendidikan_terakhir"
                                id="g_pendidikan"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea
                                name="alamat_guru"
                                id="g_alamat"
                                class="form-control"
                                rows="2"
                                required
                            ></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis E-Wallet</label>
                            <input
                                type="text"
                                name="jenis_e_wallet"
                                id="g_wallet_tipe"
                                class="form-control"
                                placeholder="Dana/OVO"
                                required
                            />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No E-Wallet</label>
                            <input
                                type="text"
                                name="no_e_wallet"
                                id="g_wallet_no"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rekening Bank</label>
                            <input
                                type="text"
                                name="rekening"
                                id="g_rekening"
                                class="form-control"
                                placeholder="Nama Bank - No Rek"
                                required
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="btnSimpanGuru"
                    >
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form id="formSiswa">
            @csrf <input type="hidden" name="id" id="s_id" />
            <input type="hidden" name="_method" id="s_method" value="POST" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleSiswa">Form Siswa</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <input
                                type="text"
                                name="nama"
                                id="s_nama"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenjang</label>
                            <select
                                name="jenjang"
                                id="s_jenjang"
                                class="form-control form-select"
                            >
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kelas</label>
                            <input
                                type="text"
                                name="kelas"
                                id="s_kelas"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP</label>
                            <input
                                type="text"
                                name="no_hp"
                                id="s_no_hp"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asal Sekolah</label>
                            <input
                                type="text"
                                name="asal_sekolah"
                                id="s_asal_sekolah"
                                class="form-control"
                            />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Orang Tua</label>
                            <input
                                type="text"
                                name="nama_orang_tua"
                                id="s_ortu"
                                class="form-control"
                            />
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea
                                name="alamat"
                                id="s_alamat"
                                class="form-control"
                                rows="2"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="btnSimpanSiswa"
                    >
                        Simpan
                    </button>
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

    const dataGuru = JSON.parse('{!! addslashes(json_encode($guru->keyBy("id"))) !!}');
    const dataSiswa = JSON.parse('{!! addslashes(json_encode($siswa->keyBy("id"))) !!}');

    $(document).ready(function() {
        const mGuru = new bootstrap.Modal(document.getElementById('modalGuru'));
        const mSiswa = new bootstrap.Modal(document.getElementById('modalSiswa'));

        // --- FUNGSI HELPER: FORMAT ALERT NATIVE (LIST) ---
        function showValidationAlert(title, errorList) {
            let msg = title + "\n\n";
            errorList.forEach(function(error) {
                msg += "- " + error + "\n";
            });
            alert(msg);
        }

        // --- FUNGSI HELPER: HANDLE AJAX ERROR ---
        function handleAjaxError(xhr, btnId, btnTextDefault) {
            $(`#${btnId}`).text(btnTextDefault).prop('disabled', false);
            
            let errorList = [];
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, val) {
                    errorList.push(val[0]);
                });
                showValidationAlert('Gagal Menyimpan Data:', errorList);
            } else {
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan pada server.';
                alert('Error: ' + msg);
            }
        }

        // --- CLIENT SIDE PAGINATION ---
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
                    
                    let startPage = Math.max(1, currentPage - 2);
                    let endPage = Math.min(totalPages, currentPage + 2);

                    if(startPage > 1) $container.append(`<button type="button" class="btn-page num" data-page="1">1</button>`);
                    if(startPage > 2) $container.append(`<span class="px-1 text-muted">...</span>`);

                    for (let i = startPage; i <= endPage; i++) {
                        $container.append(`<button type="button" class="btn-page num ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`);
                    }

                    if(endPage < totalPages - 1) $container.append(`<span class="px-1 text-muted">...</span>`);
                    if(endPage < totalPages) $container.append(`<button type="button" class="btn-page num" data-page="${totalPages}">${totalPages}</button>`);

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
            
            // --- VALIDASI CUSTOM GURU ---
            let nama = $('#g_nama').val();
            let hp = $('#g_no_hp').val();
            let jenisWallet = $('#g_wallet_tipe').val(); // Ambil nilai Jenis Wallet
            let noWallet = $('#g_wallet_no').val();      // Ambil nilai No Wallet
            
            let clientErrors = [];

            // 1. Validasi Nama (Tidak boleh angka)
            if (/\d/.test(nama)) {
                clientErrors.push('Nama Lengkap tidak boleh mengandung angka.');
            }

            // 2. Validasi No HP (Tidak boleh huruf)
            if (/[a-zA-Z]/.test(hp)) {
                clientErrors.push('Nomor HP tidak boleh mengandung huruf.');
            }

            // 3. Validasi Jenis E-Wallet (Tidak boleh angka) -> BARU DITAMBAHKAN
            if (jenisWallet && /\d/.test(jenisWallet)) {
                clientErrors.push('Jenis E-Wallet tidak boleh mengandung angka.');
            }

            // 4. Validasi No E-Wallet (Tidak boleh huruf)
            if (noWallet && /[a-zA-Z]/.test(noWallet)) {
                clientErrors.push('Nomor E-Wallet tidak boleh mengandung huruf.');
            }

            // Tampilkan error jika ada
            if (clientErrors.length > 0) {
                showValidationAlert('Data Tidak Valid:', clientErrors);
                return false; 
            }
            // --- END VALIDASI ---

            let id = $('#g_id').val();
            let url = id ? ('/admin/guru/update/' + id) : '/admin/guru/store';
            
            $('#btnSimpanGuru').text('Menyimpan...').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    mGuru.hide();
                    alert('Berhasil! ' + res.message);
                    location.reload();
                },
                error: function(xhr) {
                    handleAjaxError(xhr, 'btnSimpanGuru', 'Simpan');
                }
            });
        });

        // ==========================================
        // LOGIKA SISWA (CRUD)
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
            
            $('#titleSiswa').text('Edit Data Siswa');
            $('#formSiswa')[0].reset();
            $('#s_id').val(s.id);
            $('#s_method').val('PUT');
            
            $('#s_nama').val(s.nama);
            
            if (s.jenjang) {
                let jenjangFix = String(s.jenjang).toUpperCase().trim();
                $('#s_jenjang').val(jenjangFix);
            } else {
                $('#s_jenjang').val('');
            }
            $('#s_jenjang').trigger('change');

            $('#s_kelas').val(s.kelas);
            $('#s_no_hp').val(s.no_hp);
            $('#s_asal_sekolah').val(s.asal_sekolah);
            $('#s_ortu').val(s.nama_orang_tua);
            $('#s_alamat').val(s.alamat);
            
            mSiswa.show();
        });

        $('#formSiswa').submit(function(e) {
            e.preventDefault();

            // --- VALIDASI CUSTOM SISWA ---
            let nama = $('#s_nama').val();
            let hp = $('#s_no_hp').val();
            let clientErrors = [];

            if (/\d/.test(nama)) {
                clientErrors.push('Nama Siswa tidak boleh mengandung angka.');
            }
            if (hp && /[a-zA-Z]/.test(hp)) {
                clientErrors.push('Nomor HP tidak boleh mengandung huruf.');
            }

            if (clientErrors.length > 0) {
                showValidationAlert('Data Tidak Valid:', clientErrors);
                return false;
            }
            // --- END VALIDASI ---

            let id = $('#s_id').val();
            let url = id ? ('/admin/siswa/update/' + id) : '/admin/siswa/store';
            
            $('#btnSimpanSiswa').text('Menyimpan...').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    mSiswa.hide();
                    alert('Berhasil! ' + res.message);
                    location.reload();
                },
                error: function(xhr) {
                    handleAjaxError(xhr, 'btnSimpanSiswa', 'Simpan');
                }
            });
        });

        // --- UPDATE STATUS ---
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
                    console.log('Status diperbarui');
                },
                error: function() {
                    alert('Error: Gagal update status');
                }
            });
        });
    });
</script>
@endsection

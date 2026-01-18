@extends('layouts.app_admin', ['title' => 'Penerimaan Siswa'])

@section('content')

{{-- --- BAGIAN CSS --- --}}
<style>
    /* Style Dropdown Status */
    .custom-status-dropdown {
        border: none; border-radius: 20px; padding: 5px 15px; color: white;
        font-size: 13px; font-weight: 500; appearance: none; cursor: pointer;
        /* Icon Panah Putih Custom */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px;
        transition: background-color 0.3s ease;
    }
    
    /* Warna Status */
    .status-tertunda { background-color: #fffde7 !important; color: #856404 !important; border: 1px solid #ffeeba !important; }
    .status-diterima { background-color: #e8f5e9 !important; color: #155724 !important; border: 1px solid #c3e6cb !important; }

    /* Style Tombol WhatsApp */
    .btn-wa {
        background-color: #25D366;
        color: white !important;
        border: 1px solid #25D366;
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-wa:hover {
        background-color: #1DA851;
        border-color: #1DA851;
        box-shadow: 0 2px 5px rgba(37, 211, 102, 0.4);
    }

    /* Style Tabel & Pagination */
    .pagination-wrapper { display: flex; justify-content: center; width: 100%; margin-top: 20px; }
    .pagination-container { display: flex; gap: 8px; justify-content: center; }
    .btn-page { border: 1px solid #e2e8f0; background: white; padding: 8px 16px; border-radius: 8px; font-size: 14px; color: #4a5568; cursor: pointer; }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; border-color: #3182ce; }
    .btn-page:disabled { opacity: 0.5; cursor: default; }
    
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }
    .col-aksi { white-space: nowrap; width: 1%; }
</style>

<div class="table-container">
    {{-- --- TABEL DATA --- --}}
    <table class="table-general" id="penerimaanTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenjang</th>
                <th>No Hp</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($siswa as $s)
            @php
                $status = $s->status_penerimaan ?? 0; 
                
                // Tentukan Class CSS (0 = Tertunda, 1 = Diterima)
                $cls = ($status == 1) ? 'status-diterima' : 'status-tertunda';

                // --- LOGIKA FORMAT NOMOR HP ---
                $hp_bersih = preg_replace('/[^0-9]/', '', $s->no_hp);
                if (substr($hp_bersih, 0, 1) == '0') {
                    $hp_final = '62' . substr($hp_bersih, 1);
                } else {
                    $hp_final = $hp_bersih;
                }
            @endphp
            <tr id="row-{{ $s->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->jenjang }}</td>
                <td>{{ $s->no_hp }}</td>
                <td>{{ $s->alamat }}</td>
                <td>
                    {{-- DROPDOWN STATUS --}}
                    <select class="form-select form-select-sm custom-status-dropdown {{ $cls }}" data-id="{{ $s->id }}">
                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>Tertunda</option>
                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Terima</option>
                    </select>
                </td>
                <td class="col-aksi text-center">
                    {{-- TOMBOL PEMICU MODAL (Hanya muncul jika Status == 0 / Tertunda) --}}
                    {{-- Menggunakan class d-none untuk hide/show agar tidak error syntax di editor --}}
                    <button type="button" 
                            class="btn-wa btn-pesan-wa {{ $status == 0 ? '' : 'd-none' }}"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalPesanWA"
                            data-nama="{{ $s->nama }}"
                            data-nohp="{{ $hp_final }}">
                        <i class="bi bi-whatsapp"></i> Hubungi
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div class="pagination-wrapper">
        <div class="pagination-container" id="paginationPenerimaan"></div>
    </div>
</div>

{{-- --- MODAL INPUT PESAN WHATSAPP --- --}}
<div class="modal fade" id="modalPesanWA" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" style="font-size: 1rem;">
                    <i class="bi bi-whatsapp me-2"></i>Kirim Pesan WhatsApp
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formKirimWA">
                    {{-- Hidden input untuk menyimpan nomor HP sementara --}}
                    <input type="hidden" id="inputNomorHP">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted" style="font-size: 0.85rem;">Penerima</label>
                        <input type="text" class="form-control fw-bold" id="inputNamaSiswa" readonly style="background-color: #f8f9fa;">
                    </div>

                    <div class="mb-3">
                        <label for="inputPesan" class="form-label fw-bold text-muted" style="font-size: 0.85rem;">Isi Pesan</label>
                        <textarea class="form-control" id="inputPesan" rows="6" style="resize: none; font-size: 0.9rem;"></textarea>
                        <div class="form-text text-muted" style="font-size: 0.75rem;">
                            Anda dapat mengedit pesan di atas sebelum mengirim.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success btn-sm" id="btnKirimReal">
                    <i class="bi bi-send me-1"></i> Kirim Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

{{-- --- BAGIAN JAVASCRIPT --- --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // 1. --- LOGIKA PAGINATION ---
    const rowsPerPage = 10;
    let currentPage = 1;
    const $rows = $("#penerimaanTable tbody tr");

    function renderPagination() {
        const totalPages = Math.ceil($rows.length / rowsPerPage);
        const $controls = $("#paginationPenerimaan");
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

    $(document).on("click", ".num", function () { currentPage = $(this).data("page"); renderPagination(); });
    $(document).on("click", ".prev", function () { if (currentPage > 1) { currentPage--; renderPagination(); } });
    $(document).on("click", ".next", function () { if (currentPage < Math.ceil($rows.length / rowsPerPage)) { currentPage++; renderPagination(); } });

    renderPagination();


    // 2. --- LOGIKA UPDATE STATUS (AJAX) ---
    $(document).on("change", ".custom-status-dropdown", function () {
        const statusVal = $(this).val(); 
        const idSiswa = $(this).data("id"); 
        const $dropdown = $(this);
        const $row = $dropdown.closest('tr');
        const $btnWa = $row.find('.btn-pesan-wa'); 

        $.ajax({
            url: "/admin/update-status-siswa/" + idSiswa, 
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status_penerimaan: statusVal
            },
            success: function (response) {
                // Hapus class lama terlebih dahulu
                $dropdown.removeClass('status-tertunda status-diterima');
                
                if (statusVal == 1) {
                    // Jika Status = Terima (1)
                    $dropdown.addClass('status-diterima');
                    // Sembunyikan tombol WA (tambah class d-none)
                    $btnWa.addClass('d-none');
                } else {
                    // Jika Status = Tertunda (0)
                    $dropdown.addClass('status-tertunda');
                    // Tampilkan tombol WA (hapus class d-none)
                    $btnWa.removeClass('d-none');
                }
                
                if(response && response.message) {
                    console.log(response.message);
                }
            },
            error: function (xhr) {
                alert("Gagal update status: " + xhr.statusText);
            }
        });
    });


    // 3. --- LOGIKA MODAL WHATSAPP ---
    // Saat tombol "Hubungi" diklik, isi data ke dalam Modal
    $('#modalPesanWA').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var nama = button.data('nama');
        var nohp = button.data('nohp');

        // Template Pesan Default
        var templatePesan = "Halo " + nama + ",\n\n" +
                            "Kami dari *Admin Akademi Cendekia* ingin menginformasikan bahwa status pendaftaran Anda saat ini masih *Tertunda*.\n\n" +
                            "Mohon konfirmasi atau lengkapi data Anda.\n" +
                            "Terima Kasih.";

        var modal = $(this);
        modal.find('#inputNamaSiswa').val(nama);
        modal.find('#inputNomorHP').val(nohp);
        modal.find('#inputPesan').val(templatePesan);
    });

    // Saat tombol "Kirim Sekarang" di Modal diklik
    $('#btnKirimReal').click(function() {
        var nohp = $('#inputNomorHP').val();
        var pesanManual = $('#inputPesan').val(); 

        if (!pesanManual) {
            alert("Pesan tidak boleh kosong!");
            return;
        }

        // Encode pesan (mengubah spasi/enter jadi format URL)
        var pesanEncoded = encodeURIComponent(pesanManual);
        
        // Buka Tab Baru WhatsApp
        var urlWA = "https://wa.me/" + nohp + "?text=" + pesanEncoded;
        window.open(urlWA, '_blank');

        // Tutup Modal
        $('#modalPesanWA').modal('hide');
    });
});
</script>

@endsection
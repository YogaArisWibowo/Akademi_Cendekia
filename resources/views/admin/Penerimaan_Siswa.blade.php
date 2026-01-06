@extends('layouts.app_admin', ['title' => 'Penerimaan Siswa'])
@section('content')

<style>
    .custom-status-dropdown {
        border: none; border-radius: 20px; padding: 5px 15px; color: white;
        font-size: 13px; font-weight: 500; appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px;
    }
    .status-pending { background-color: #fffde7 !important; color: #856404 !important; border: 1px solid #ffeeba !important; }
    .status-diterima { background-color: #e8f5e9 !important; color: #155724 !important; border: 1px solid #c3e6cb !important; }
    .status-ditolak { background-color: #ffebee !important; color: #721c24 !important; border: 1px solid #f5c6cb !important; }

    /* Pagination Styling */
    .pagination-wrapper { display: flex; justify-content: center; width: 100%; margin-top: 20px; }
    .pagination-container { display: flex; gap: 8px; justify-content: center; }
    .btn-page { border: 1px solid #e2e8f0; background: white; padding: 8px 16px; border-radius: 8px; font-size: 14px; color: #4a5568; cursor: pointer; }
    .btn-page.active { background-color: #ebf4ff; color: #3182ce; font-weight: 600; border-color: #3182ce; }
    .btn-page:disabled { opacity: 0.5; cursor: default; }
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }
</style>

<div class="table-container">
    <table class="table-general" id="penerimaanTable">
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>Jenjang</th><th>No Hp</th><th>Alamat</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($siswa as $s)
            @php
                $status = $s->status_penerimaan ?? 0; 
                $cls = ($status == 1) ? 'status-diterima' : (($status == 2) ? 'status-ditolak' : 'status-pending');
            @endphp
            <tr id="row-{{ $s->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->jenjang }}</td>
                <td>{{ $s->no_hp }}</td>
                <td>{{ $s->alamat }}</td>
                <td>
                    <select class="form-select form-select-sm custom-status-dropdown {{ $cls }}" data-id="{{ $s->id }}">
                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Terima</option>
                        <option value="2" {{ $status == 2 ? 'selected' : '' }}>Tolak</option>
                    </select>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper">
        <div class="pagination-container" id="paginationPenerimaan"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // --- PAGINATION (Tetap Sama) ---
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

    // --- AJAX UPDATE STATUS (PERBAIKAN DI SINI) ---
    $(document).on("change", ".custom-status-dropdown", function () {
    const statusVal = $(this).val(); 
    const idSiswa = $(this).data("id"); 
    const $dropdown = $(this);

    $.ajax({
        // Gunakan variabel idSiswa untuk mengisi {id}
        url: "/admin/update-status-siswa/" + idSiswa, 
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            status_penerimaan: statusVal // Nama kunci harus sama dengan di Controller
        },
            success: function (response) {
                // Update warna CSS
                $dropdown.removeClass('status-pending status-diterima status-ditolak');
                
                if (statusVal == 1) {
                    $dropdown.addClass('status-diterima');
                } else if (statusVal == 2) {
                    $dropdown.addClass('status-ditolak');
                } else {
                    $dropdown.addClass('status-pending');
                }
                console.log(response.message);
            },
            error: function (xhr) {
                alert("Terjadi kesalahan: " + xhr.statusText);
            }
        });
    });
});
</script>
@endsection
@extends('layouts.app_admin', ['title' => 'Penerimaan Siswa'])
@section('content')

<style>
    .custom-status-dropdown {
        border-radius: 15px !important; 
        padding: 5px 15px; 
        border-color: #3f51b5; 
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
    }
    .status-pending { background-color: #fffde7 !important; color: #856404 !important; border: 1px solid #ffeeba !important; }
    .status-diterima { background-color: #e8f5e9 !important; color: #155724 !important; border: 1px solid #c3e6cb !important; }
    .status-ditolak { background-color: #ffebee !important; color: #721c24 !important; border: 1px solid #f5c6cb !important; }
</style>

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenjang</th>
                <th>No Hp</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($siswa as $s)
            @php
                // MENGAMBIL STATUS AKTIF DARI DATABASE
                // 0 = Pending, 1 = Diterima/Aktif, 2 = Ditolak
                $status = $s->status_penerimaan ?? 0; 
                
                if($status == 1) { 
                    $cls = 'status-diterima'; 
                } elseif($status == 2) { 
                    $cls = 'status-ditolak'; 
                } else { 
                    $cls = 'status-pending'; 
                }
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('select.custom-status-dropdown').on("change", function () {
        var $dropdown = $(this);
        var selectedValue = $dropdown.val();
        var siswaId = $dropdown.data('id');

        $.ajax({
            url: "/admin/update-status-siswa/" + siswaId,
            type: "POST",
            data: { 
                _token: '{{ csrf_token() }}', 
                status_penerimaan: selectedValue // Mengirim field status_aktif
            },
            success: function (response) {
                $dropdown.removeClass('status-pending status-diterima status-ditolak');
                if (selectedValue == "1") {
                    $dropdown.addClass("status-diterima");
                } else if (selectedValue == "2") {
                    $dropdown.addClass("status-ditolak");
                } else {
                    $dropdown.addClass("status-pending");
                }
            },
            error: function () {
                alert("Gagal memperbarui status penerimaan di database.");
            }
        });
    });
});
</script>
@endsection
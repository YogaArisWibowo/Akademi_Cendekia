@extends('layouts.app_admin', ['title' => 'Tambah Mapel']) 

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
    .table-general { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
    .table-general thead th { background-color: #CCE0FF !important; color: #333; padding: 12px; border: none; font-size: 13px; white-space: nowrap; }
    .table-general tbody td { padding: 12px; border: none; vertical-align: middle; font-size: 13px; }
    .table-general tbody tr:nth-child(even) { background-color: #EBF3FF; }
    
    .search { width: 250px; position: relative; display: inline-block; }
    .search i { position: absolute; top: 50%; left: 10px; transform: translateY(-50%); color: #6c757d; }
    .search input.form-control { padding-left: 35px; height: 35px; border-radius: 6px; }

    .pagination-wrapper { display: flex; justify-content: center; width: 100%; margin-top: 20px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <p class="data-title">Data Mapel</p>
    </div>
    <button class="tambah" id="btn-tambah-mapel">
        Tambah <i class="bi bi-plus"></i>
    </button>
</div>

<div class="table-container">
    <table class="table-general" id="mapellTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                <th>Kurikulum</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mapel as $m)
            <tr>
                <td>{{ $loop->iteration + ($mapel->firstItem() - 1) }}</td>
                <td>{{ $m->nama_mapel }}</td>
                <td>{{ $m->jenis_kurikulum }}</td>
                <td>{{ $m->kelas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination-wrapper">
        {{ $mapel->links() }}
    </div>
</div>

<div class="modal fade" id="modalTambahMapel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mapel Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mapel.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Mapel</label>
                        <input type="text" name="nama_mapel" class="form-control" placeholder="Input Nama Mapel" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kurikulum</label>
                        <select name="jenis_kurikulum" class="form-control" required>
                            <option value="Merdeka">Kurikulum Merdeka</option>
                            <option value="K13">K13</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Input Kelas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="tambah" style="border: none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn-tambah-mapel').on('click', function() {
            $('#modalTambahMapel').modal('show');
        });
    });
</script>

@endsection
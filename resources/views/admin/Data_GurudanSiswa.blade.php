@extends('layouts.app_admin', ['title' => 'Data Guru & Siswa'])
@section('content')

<style>
    .tambah { margin-bottom: 5px; display: flex; justify-content: center; color: white; border: none; border-radius: 6px; background-color: #ffd700; font-weight: 500 !important; align-items: center; width: 110px; height: 35px; text-decoration: none; }
    .data, .data-siswa { font-weight: 600 !important; font-size: 30px; padding-left: 15px; }
    .table-container { width: 100%; overflow-x: auto; background: white; padding: 15px; border-radius: 8px; }
    .table-general { width: 100%; min-width: 1300px; border-collapse: collapse; }
    .table-general th, .table-general td { padding: 12px 8px; border-bottom: 1px solid #eee; text-align: left; }
    
    /* CSS Status Colors */
    .custom-status-dropdown { border-radius: 15px !important; padding: 5px 15px; border: 1px solid #3f51b5; font-size: 12px; }
    .status-aktif { background-color: #e8f5e9 !important; color: #2e7d32 !important; font-weight: bold; }
    .status-non-aktif { background-color: #ffebee !important; color: #c62828 !important; font-weight: bold; }
    .status-pending { background-color: #fffde7 !important; color: #856404 !important; font-weight: bold; }
</style>

{{-- TABEL GURU --}}
<div class="d-flex justify-content-between align-items-center mb-2">
    <p class="data">Data Guru</p>
    <button class="tambah" data-bs-toggle="modal" data-bs-target="#modalTambahDataGuru" onclick="resetFormGuru()">Tambah <i class="bi bi-plus"></i></button>
</div>
<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>Email</th><th>Pendidikan</th><th>Mapel</th><th>Alamat</th><th>No Hp</th><th>Rekening</th><th>E-Wallet</th><th>No Wallet</th><th>Status</th><th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guru as $g)
            @php $cls = $g->status_aktif == 'aktif' ? 'status-aktif' : 'status-non-aktif'; @endphp
            <tr class="{{ $g->status_aktif == 'aktif' ? 'table-success' : 'table-secondary' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $g->nama }}</td>
                <td>{{ $g->user->email ?? '-' }}</td>
                <td>{{ $g->pendidikan_terakhir }}</td>
                <td>{{ $g->mapel }}</td>
                <td>{{ $g->alamat_guru }}</td>
                <td>{{ $g->no_hp }}</td>
                <td>{{ $g->rekening }}</td>
                <td>{{ $g->jenis_e_wallet }}</td>
                <td>{{ $g->no_e_wallet }}</td>
                <td>
                    <select class="form-select form-select-sm custom-status-dropdown {{ $cls }}" onchange="updateStatus('guru', {{ $g->id }}, this)">
                        <option value="aktif" {{ $g->status_aktif == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non aktif" {{ $g->status_aktif == 'non aktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info" onclick="editModeGuru({{ json_encode($g->load('user')) }})"><i class="bi bi-pencil-square text-white"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL GURU (Gunakan input name yang sesuai controller) --}}
<div class="modal fade" id="modalTambahDataGuru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formGuru" method="POST" action="{{ route('guru.store') }}">
            @csrf <div id="methodGuru"></div>
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Data Guru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3"><label>Nama Guru</label><input type="text" name="nama" id="guru_nama" class="form-control" required></div>
                            <div class="mb-3"><label>Email</label><input type="email" name="email" id="guru_email" class="form-control" required></div>
                            <div class="mb-3"><label>Pendidikan Terakhir</label><input type="text" name="pendidikan" id="guru_pendidikan" class="form-control" required></div>
                            <div class="mb-3"><label>Mapel</label><select name="mapel" id="guru_mapel" class="form-control" required><option value="Matematika">Matematika</option><option value="Bahasa Inggris">Bahasa Inggris</option></select></div>
                            <div class="mb-3"><label>Alamat</label><input type="text" name="alamat_guru" id="guru_alamat" class="form-control" required></div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label>Jenis E-Wallet</label><select name="jenis" id="guru_jenis" class="form-control" required><option value="Dana">Dana</option><option value="Gopay">Gopay</option></select></div>
                            <div class="mb-3"><label>No E-Wallet</label><input type="text" name="no_e-wallet" id="guru_no_wallet" class="form-control" required></div>
                            <div class="mb-3"><label>Rekening</label><input type="text" name="rekening" id="guru_rekening" class="form-control" required></div>
                            <div class="mb-3"><label>No Hp</label><input type="text" name="no_hp" id="guru_hp" class="form-control" required></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL SISWA --}}
<div class="d-flex justify-content-between align-items-center mb-2 mt-5">
    <p class="data-siswa">Data Siswa</p>
    <button class="tambah" data-bs-toggle="modal" data-bs-target="#modalTambahDataSiswa" onclick="resetFormSiswa()">Tambah <i class="bi bi-plus"></i></button>
</div>
<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>Email</th><th>Jenjang</th><th>Kelas</th><th>Asal Sekolah</th><th>Orang Tua</th><th>No Hp</th><th>Status</th><th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $s)
            @php 
                $st = $s->status_penerimaan;
                $cls = $st == 1 ? 'status-aktif' : ($st == 2 ? 'status-non-aktif' : 'status-pending');
                $row = $st == 1 ? 'table-success' : ($st == 2 ? 'table-danger' : 'table-warning');
            @endphp
            <tr class="{{ $row }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->nama }}</td>
                <td>{{ $s->user->email ?? '-' }}</td>
                <td>{{ $s->jenjang }}</td>
                <td>{{ $s->kelas }}</td>
                <td>{{ $s->asal_sekolah }}</td>
                <td>{{ $s->nama_orang_tua }}</td>
                <td>{{ $s->no_hp }}</td>
                <td>
                    <select class="form-select form-select-sm custom-status-dropdown {{ $cls }}" onchange="updateStatus('siswa', {{ $s->id }}, this)">
                        <option value="0" {{ $st == 0 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $st == 1 ? 'selected' : '' }}>Terima</option>
                        <option value="2" {{ $st == 2 ? 'selected' : '' }}>Tolak</option>
                    </select>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info" onclick="editModeSiswa({{ json_encode($s->load('user')) }})"><i class="bi bi-pencil-square text-white"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL SISWA --}}
<div class="modal fade" id="modalTambahDataSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formSiswa" method="POST" action="{{ route('siswa.store') }}">
            @csrf <div id="methodSiswa"></div>
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Tambah Data Siswa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3"><label>Nama Siswa</label><input type="text" name="nama" id="siswa_nama" class="form-control" required></div>
                            <div class="mb-3"><label>Email</label><input type="email" name="email" id="siswa_email" class="form-control"></div>
                            <div class="mb-3"><label>Jenjang</label><select name="jenjang" id="siswa_jenjang" class="form-control"><option value="SD">SD</option><option value="SMP">SMP</option><option value="SMA">SMA</option></select></div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label>Kelas</label><input type="text" name="kelas" id="siswa_kelas" class="form-control"></div>
                            <div class="mb-3"><label>Asal Sekolah</label><input type="text" name="asal_sekolah" id="siswa_asal" class="form-control"></div>
                            <div class="mb-3"><label>Nama Orang Tua</label><input type="text" name="nama_ortu" id="siswa_ortu" class="form-control"></div>
                            <div class="mb-3"><label>No Hp</label><input type="text" name="no_hp" id="siswa_hp" class="form-control"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateStatus(role, id, element) {
        let val = $(element).val();
        $(element).removeClass('status-aktif status-non-aktif status-pending');
        if (val == 'aktif' || val == '1') $(element).addClass('status-aktif');
        else if (val == 'non aktif' || val == '2') $(element).addClass('status-non-aktif');
        else $(element).addClass('status-pending');

        $.ajax({
            url: "/admin/update-status/" + role + "/" + id,
            type: "POST",
            data: { _token: '{{ csrf_token() }}', status: val },
            success: function() { console.log("Success"); }
        });
    }

    function editModeGuru(data) {
        $('#modalTambahDataGuru .modal-title').text("Edit Data Guru");
        $('#formGuru').attr('action', "/admin/guru/update/" + data.id);
        $('#methodGuru').html('<input type="hidden" name="_method" value="PUT">');
        $('#guru_nama').val(data.nama);
        $('#guru_email').val(data.user ? data.user.email : '');
        $('#guru_pendidikan').val(data.pendidikan_terakhir);
        $('#guru_mapel').val(data.mapel);
        $('#guru_alamat').val(data.alamat_guru);
        $('#guru_jenis').val(data.jenis_e_wallet);
        $('#guru_no_wallet').val(data.no_e_wallet);
        $('#guru_rekening').val(data.rekening);
        $('#guru_hp').val(data.no_hp);
        new bootstrap.Modal(document.getElementById('modalTambahDataGuru')).show();
    }

    function resetFormGuru() {
        $('#modalTambahDataGuru .modal-title').text("Tambah Data Guru");
        $('#formGuru').attr('action', "{{ route('guru.store') }}");
        $('#methodGuru').empty();
        $('#formGuru')[0].reset();
    }

    function editModeSiswa(data) {
        $('#modalTambahDataSiswa .modal-title').text("Edit Data Siswa");
        $('#formSiswa').attr('action', "/admin/siswa/update/" + data.id);
        $('#methodSiswa').html('<input type="hidden" name="_method" value="PUT">');
        $('#siswa_nama').val(data.nama);
        $('#siswa_email').val(data.user ? data.user.email : '');
        $('#siswa_jenjang').val(data.jenjang);
        $('#siswa_kelas').val(data.kelas);
        $('#siswa_asal').val(data.asal_sekolah);
        $('#siswa_ortu').val(data.nama_orang_tua);
        $('#siswa_hp').val(data.no_hp);
        new bootstrap.Modal(document.getElementById('modalTambahDataSiswa')).show();
    }

    function resetFormSiswa() {
        $('#modalTambahDataSiswa .modal-title').text("Tambah Data Siswa");
        $('#formSiswa').attr('action', "{{ route('siswa.store') }}");
        $('#methodSiswa').empty();
        $('#formSiswa')[0].reset();
    }
</script>
@endsection
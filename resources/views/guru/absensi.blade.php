@extends('layouts.app_guru', ['title' => 'Absensi Guru'])

@section('content')
    <main>
        <header class="topbar">
            <h2>Absensi Guru</h2>
            <div class="profile">
                <span>👤</span>
                <span>Ira S.</span>
                <span>▼</span>
            </div>
        </header>

        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="filter-section d-flex justify-content-between align-items-center mb-4">
            <select class="dropdown-hari">
                <option>Bulan</option>
                <option>Januari</option>
                <option>Februari</option>
            </select>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAbsenModal">
                Tambah Absen <i class="bi bi-plus-circle me-1"></i>
            </button>
        </div>

        <div class="table-wrapper">
            
            {{-- MODAL TAMBAH ABSENSI GURU --}}
            <div class="modal fade" id="tambahAbsenModal" tabindex="-1" aria-labelledby="tambahAbsenLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahAbsenLabel">Tambah Absensi Guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Hari</label>
                                        <input type="text" class="form-control" name="hari" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Waktu</label>
                                        <input type="time" class="form-control" name="waktu" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Mata Pelajaran</label>
                                        <input type="text" class="form-control" name="mapel" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Bukti Kehadiran (Foto)</label>
                                        <input type="file" class="form-control" name="bukti_foto" accept="image/*" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Laporan/Catatan Kegiatan</label>
                                        <textarea class="form-control" name="laporan_kegiatan" rows="3" required></textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Absen</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            {{-- AKHIR MODAL --}}

            {{-- TABEL ABSENSI GURU --}}
            <table class="table-jadwal">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Mapel</th>
                        <th>Bukti Foto</th>
                        <th>Catatan Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>Senin</td>
                        <td>05-Okt-2025</td>
                        <td>15.00</td>
                        <td>IPAS</td>
                        <td>Ira Sulistya</td>
                        <td>Hafidz</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Senin</td>
                        <td>05-Okt-2025</td>
                        <td>15.00</td>
                        <td>IPAS</td>
                        <td>Ira Sulistya</td>
                        <td>Hafidz</td>
                    </tr>
                </tbody>
            </table>
            {{-- AKHIR TABEL --}}

            <div class="pagination">
                <button class="btn">Sebelumnya</button>
                <button class="btn active">1</button>
                <button class="btn">2</button>
                <button class="btn">3</button>
                <button class="btn">Selanjutnya</button>
            </div>
        </div>
    </main>
@endsection
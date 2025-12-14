{{-- @extends('layouts.app_guru', ['title' => 'Jadwal Mengajar']) --}}

{{-- @section('content')
    <main>
        <header class="topbar">
            <h2>Jadwal Mengajar</h2>
            <div class="profile">
                <span>👤</span>
                <span>Ira S.</span>
                <span>▼</span>
            </div>
        </header>

        <div class="filter-section">
            <select class="dropdown-hari">
                <option>Hari</option>
                <option>Senin</option>
                <option>Selasa</option>
            </select>
        </div>

        <div class="table-wrapper">
            <table class="table-jadwal">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Mapel</th>
                        <th>Nama</th>
                        <th>Nama Siswa</th>
                        <th>Alamat Siswa</th>
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
                        <td>Jl. Kenari</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Senin</td>
                        <td>05-Okt-2025</td>
                        <td>15.00</td>
                        <td>IPAS</td>
                        <td>Ira Sulistya</td>
                        <td>Hafidz</td>
                        <td>Jl. Kenari</td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button class="btn">Sebelumnya</button>
                <button class="btn active">1</button>
                <button class="btn">2</button>
                <button class="btn">3</button>
                <button class="btn">Selanjutnya</button>
            </div>
        </div>
    </main>
@endsection --}}


@extends('layouts.app_guru', ['title' => 'Jadwal Mengajar'])

@section('content')

<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Mapel</th>
                <th>Nama</th>
                <th>Nama Siswa</th>
                <th>Alamat Siswa</th>
            </tr>
        </thead>

        <tbody>
        {{-- @foreach($jadwal as $i => $j)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $j->hari }}</td>
                <td>{{ $j->tanggal }}</td>
                <td>{{ $j->waktu }}</td>
                <td>{{ $j->mapel }}</td>
                <td>{{ $j->guru }}</td>
                <td>{{ $j->nama_siswa }}</td>
                <td>{{ $j->alamat_siswa }}</td>
            </tr>
        @endforeach --}}
        </tbody>
    </table>

    <div class="pagination-wrapper">
        <button class="btn page">Sebelumnya</button>
        <button class="btn page active">1</button>
        <button class="btn page">2</button>
        <button class="btn page">3</button>
        <button class="btn page active">Selanjutnya</button>
    </div>

</div>

@endsection

@extends('layouts.app_siswa', ['title' => 'Jadwal Bimbel'])

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
        @foreach($jadwal as $i => $j)
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
        @endforeach
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

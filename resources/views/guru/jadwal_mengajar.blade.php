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
                    <th>Nama Guru</th>
                    <th>Nama Siswa</th>
                    <th>Alamat Siswa</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($jadwal as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</td>
                        <td>{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                        <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                        <td>{{ $item->guru->nama ?? '-' }}</td>
                        <td>{{ $item->siswa->nama ?? '-' }}</td>
                        <td>{{ $item->alamat_siswa }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Ganti div pagination-wrapper yang lama dengan ini --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $jadwal->links() }}
        </div>

    </div>
@endsection

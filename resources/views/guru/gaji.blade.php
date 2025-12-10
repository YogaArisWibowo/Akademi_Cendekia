@extends('layouts.app_guru', ['title' => 'Jadwal Mengajar'])

@section('content')
    <main>
        <header class="topbar">
            <h2>Gaji Guru</h2>
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
                        <th>Nama</th>
                        <th>Guru Jenjang</th>
                        <th>Rekening</th>
                        <th>Gaji Per jam</th>
                        <th>Absensi</th>
                        <th>Total</th>
                        <th>Status</th>
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

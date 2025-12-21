{{-- resources/views/siswa/siswa_pencatatanpembayaran.blade.php --}}
@extends('layouts.app_siswa', ['title' => 'Pembayaran Bimbel'])

@section('content')
<div class="pembayaran-header d-flex align-items-center justify-content-end mb-3">
    <div class="right-head">
        <button type="button" class="btn-add d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalPembayaran">
            <span>Tambah</span>
            <i class="ri-add-line ms-2"></i>
        </button>
    </div>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Table --}}
<div class="table-container">
    <table class="table-general">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas/Jenjang</th>
                <th>No hp</th>
                <th>Nominal</th>
                <th class="text-center">Bukti Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $idx => $item)
                @php
                    $tgl = \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('l, d–M–Y');
                    $s = $item->siswa;
                @endphp
                <tr>
                    <td>{{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + $idx + 1 }}.</td>
                    <td>{{ $tgl }}</td>
                    <td>{{ $s?->nama ?? '-' }}</td>
                    <td>{{ $s?->jenjang ?? '-' }}</td>
                    <td>{{ $s?->no_hp ?? '-' }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($item->bukti_pembayaran)
                            <a href="{{ asset('storage/'.$item->bukti_pembayaran) }}" target="_blank">Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrapper d-flex align-items-center gap-2 mt-3">
        {{ $pembayaran->links() }}
    </div>
</div>

{{-- Modal Tambah Pembayaran --}}
<div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('siswa.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalPembayaranLabel">Tambah Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Tanggal Pembayaran</label>
          <input type="datetime-local" name="tanggal_pembayaran" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Ortu</label>
          <input type="text" name="nama_orangtua" class="form-control" maxlength="50" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Nominal (Rp)</label>
          <input type="number" name="nominal" class="form-control" min="1" step="1" placeholder="contoh: 240.000" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Bukti Pembayaran (opsional)</label>
          <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*">
          <div class="form-text">Maks 2MB. Format gambar.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
{{-- resources/views/siswa/siswa_pencatatanpembayaran.blade.php --}}
@extends('layouts.app_siswa', ['title' => 'Pembayaran Bimbel'])

@section('content')
    <div class="pembayaran-header d-flex align-items-center justify-content-end mb-3">
        <div class="right-head">
            <button type="button" class="btn-add d-inline-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#modalPembayaran">
                <span>Tambah</span>
                <i class="ri-add-line ms-2"></i>
            </button>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if (session('error'))
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
    {{-- Table --}}
    <div class="table-container">
        <table class="table-general">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    {{-- <th>Kelas/Jenjang</th> (Opsional, boleh dihapus jika sempit) --}}
                    <th>Nominal</th>
                    <th>Metode</th>
                    <th class="text-center">Status</th> {{-- Kolom Baru --}}
                    <th class="text-center">Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $idx => $item)
                    @php
                        $tgl = \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d M Y');
                        $s = $item->siswa;
                    @endphp
                    <tr>
                        <td>{{ ($pembayaran->currentPage() - 1) * $pembayaran->perPage() + $idx + 1 }}.</td>
                        <td>{{ $tgl }}</td>
                        <td>
                            <div class="fw-bold">{{ $s?->nama ?? '-' }}</div>
                            <small class="text-muted">{{ $s?->jenjang ?? '' }}</small>
                        </td>
                        <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td>{{ $item->metode_pembayaran ?? '-' }}</td>

                        {{-- LOGIKA STATUS --}}
                        <td class="text-center">
                            @if ($item->status == 'pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="ri-time-line me-1"></i> Menunggu Verifikasi
                                </span>
                            @elseif($item->status == 'lunas')
                                <span class="badge bg-success">
                                    <i class="ri-check-double-line me-1"></i> Lunas
                                </span>
                            @else
                                <span class="badge bg-secondary">{{ $item->status }}</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if ($item->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="ri-image-line"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png"
                                alt="Empty" style="width: 150px; opacity: 0.5">
                            <p class="text-muted mt-2">Belum ada riwayat pembayaran.</p>
                        </td>
                    </tr>
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
            <form action="{{ route('siswa.pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
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
                        <input type="number" name="nominal" class="form-control" min="1" step="1"
                            placeholder="contoh: 240.000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="pilihMetode" class="form-select" required
                            onchange="tampilkanRekening()">
                            <option value="" selected disabled>-- Pilih Bank / E-Wallet --</option>
                            <option value="Muamalat">Bank Muamalat</option>
                            {{-- <option value="BRI">Bank BRI</option> --}}
                            <option value="DANA">DANA </option>
                            <option value="SHOPEEPAY">ShopeePay</option>
                        </select>
                    </div>

                    {{-- AREA INFO REKENING (Akan berubah sesuai pilihan) --}}
                    <div id="infoRekening" class="alert alert-info d-none mb-3">
                        <p class="mb-1 small">Silakan transfer ke:</p>
                        <h5 class="fw-bold mb-1" id="nomorRekening">-</h5>
                        <p class="mb-0 small" id="namaPenerima">a.n Admin Bimbel</p>
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

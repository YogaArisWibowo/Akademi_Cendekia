@extends('layouts.app_guru', ['title' => 'Detail Materi Pembelajaran'])

@section('content')
<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('materi_pembelajaran') }}" class="btn btn-warning">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            Tambah +
        </button>
    </div>

    <h3 class="materi-detail-title">Bangun Datar</h3>

    <div class="materi-detail-card">
        <p><strong>Materi :</strong></p>

        <p><strong>Ringkasan :</strong></p>
        <p>
            Bangun datar merupakan bentuk dua dimensi yang memiliki luas dan keliling, namun tidak memiliki volume.
            Dalam matematika, bangun datar terdiri dari berbagai macam bentuk seperti persegi, persegi panjang, 
            segitiga, jajargenjang, trapesium, lingkaran, dan layang-layang. Setiap bangun memiliki ciri khas 
            serta rumus yang berbeda-beda untuk menghitung luas maupun kelilingnya.
        </p>

        <p>
            Persegi adalah bangun datar yang memiliki empat sisi sama panjang dan empat sudut siku-siku. 
            Persegi panjang memiliki dua pasang sisi yang sama panjang dan juga memiliki empat sudut siku-siku. 
            Segitiga merupakan bangun datar dengan tiga sisi dan tiga sudut, yang dapat berupa segitiga sama sisi,
            sama kaki, atau sembarang. Lingkaran adalah bangun datar yang terbentuk dari himpunan titik-titik 
            yang berjarak sama dari satu titik pusat.
        </p>

        <p>
            Dalam kehidupan sehari-hari, bangun datar sangat sering digunakan, misalnya dalam perancangan bangunan,
            pembuatan pola, perhitungan bahan, hingga perancangan desain grafis. Dengan memahami sifat dan rumus 
            setiap bangun datar, kita dapat menyelesaikan berbagai masalah perhitungan dengan lebih mudah.
        </p>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="#">
                {{-- @csrf --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Materi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Materi</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="ringkasan" class="form-label">Ringkasan</label>
                            <textarea class="form-control" id="ringkasan" name="ringkasan" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
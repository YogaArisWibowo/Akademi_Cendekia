@extends('layouts.app_siswa', ['title' => 'Materi Pembelajaran'])

@section('content')
<div class="content-wrapper">

    <a href="/siswa/siswa_daftarmateri" class="back-btn">
        <i class="ri-arrow-left-line"></i> Kembali
    </a>


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

</div>

@endsection

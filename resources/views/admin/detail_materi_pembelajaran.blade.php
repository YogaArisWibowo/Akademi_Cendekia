@extends('layouts.app_admin', ['title' => 'Materi Pembelajaran'])
@section('content')
<style>
    .back {
        background-color: #c7c7c7;
        border-radius: 10px;
        border: none;
        width: 110px;
        height: 35px;
        color: white;
        font-weight: 500;
        font-size: large;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .back i {
        padding-right: 5px;
    }
    .ubah {
        margin-bottom: 5px;
        display: flex;
        justify-content: flex-end;
        color: white;
        border: none;
        border-radius: 6px;
        background-color: #1876ff;
        font-weight: 600 !important;
        align-items: center;
        width: 102px;
        height: 40px;
    }
    .ubah i {
        color: white;
        font-size: 20px !important;
        padding-left: 10px;
        padding-right: 5px;
        line-height: 0;
        vertical-align: middle;
        display: inline-block;
    }
    .data {
        font-weight: 600 !important;
        font-size: 30px;
        padding-left: 15px;
    }
</style>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('Materi_Pembelajaran') }}">
            <button class="back">
                <i class="ri-arrow-left-line"></i> Kembali
            </button>
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <p class="data">Bangun Datar</p>

        <button
            class="ubah text-center"
            data-bs-toggle="modal"
            data-bs-target="#modalUbahMateri"
        >
            Ubah <i class="bi bi-pencil-square"></i>
        </button>
    </div>

    <div class="materi-detail-card">
        <p><strong>Materi :</strong></p>

        <p><strong>Ringkasan :</strong></p>
        <p>
            Bangun datar merupakan bentuk dua dimensi yang memiliki luas dan
            keliling, namun tidak memiliki volume. Dalam matematika, bangun
            datar terdiri dari berbagai macam bentuk seperti persegi, persegi
            panjang, segitiga, jajargenjang, trapesium, lingkaran, dan
            layang-layang. Setiap bangun memiliki ciri khas serta rumus yang
            berbeda-beda untuk menghitung luas maupun kelilingnya.
        </p>

        <p>
            Persegi adalah bangun datar yang memiliki empat sisi sama panjang
            dan empat sudut siku-siku. Persegi panjang memiliki dua pasang sisi
            yang sama panjang dan juga memiliki empat sudut siku-siku. Segitiga
            merupakan bangun datar dengan tiga sisi dan tiga sudut, yang dapat
            berupa segitiga sama sisi, sama kaki, atau sembarang. Lingkaran
            adalah bangun datar yang terbentuk dari himpunan titik-titik yang
            berjarak sama dari satu titik pusat.
        </p>

        <p>
            Dalam kehidupan sehari-hari, bangun datar sangat sering digunakan,
            misalnya dalam perancangan bangunan, pembuatan pola, perhitungan
            bahan, hingga perancangan desain grafis. Dengan memahami sifat dan
            rumus setiap bangun datar, kita dapat menyelesaikan berbagai masalah
            perhitungan dengan lebih mudah.
        </p>
    </div>
</div>

@endsection

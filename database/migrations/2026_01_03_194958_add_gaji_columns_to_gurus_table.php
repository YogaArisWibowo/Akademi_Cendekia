<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('guru', function (Blueprint $row) {
            // Menambahkan kolom yang dibutuhkan untuk fitur gaji
            $row->string('jenjang')->nullable()->after('nama');
            $row->string('no_rekening')->nullable()->after('jenjang');
            $row->integer('gaji_per_jam')->default(0)->after('no_rekening');
            $row->integer('absensi')->default(0)->after('gaji_per_jam');
            // Jika kolom status belum ada, aktifkan baris bawah ini:
            // $row->string('status')->default('Aktif')->after('absensi');
        });
    }

    public function down()
    {
        Schema::table('guru', function (Blueprint $row) {
            $row->dropColumn(['jenjang', 'no_rekening', 'gaji_per_jam', 'absensi']);
        });
    }
};
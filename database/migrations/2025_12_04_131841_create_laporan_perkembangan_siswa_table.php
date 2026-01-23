<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_perkembangan_siswa', function (Blueprint $table) {
    $table->unsignedInteger('Id_laporan_perkembangan')->primary();
    $table->string('Id_siswa', 10);
    $table->unsignedInteger('Id_jadwal_bimbel');
    $table->text('Laporan_perkembangan');
    $table->string('Mapel', 255);
    $table->time('Waktu');
    $table->date('Tanggal');
    $table->string('Hari', 255);
    $table->float('Nilai_rata-rata');
    $table->timestamps();

    $table->foreign('Id_siswa')->references('Id_siswa')->on('siswa')->onDelete('cascade');
    $table->foreign('Id_jadwal_bimbel')->references('Id_jadwal_bimbel')->on('jadwal_bimbel')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perkembangan_siswa');
    }
};
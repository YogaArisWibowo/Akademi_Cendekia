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
        Schema::create('absensi_siswa', function (Blueprint $table) {
    $table->unsignedInteger('Id_absensi_siswa')->primary();
    $table->string('Id_siswa', 10);
    $table->unsignedInteger('Id_jadwal_bimbel');
    $table->enum('Kehadiran', ['hadir', 'ijin', 'sakit']);
    $table->time('Waktu');
    $table->date('Tanggal');
    $table->string('Mapel', 255);
    $table->string('Bukti', 255);
    $table->text('Catatan', 255);
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
        Schema::dropIfExists('absensi_siswa');
    }
};
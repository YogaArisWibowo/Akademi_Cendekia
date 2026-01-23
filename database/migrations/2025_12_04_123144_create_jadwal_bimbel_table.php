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
        Schema::create('jadwal_bimbel', function (Blueprint $table) {
    $table->unsignedInteger('Id_jadwal_bimbel')->primary();
    $table->string('Id_siswa', 10);
    $table->string('Id_guru', 10);
    $table->unsignedInteger('Id_mapel');
    $table->char('Hari', 20);
    $table->integer('Waktu_mulai');
    $table->integer('Waktu_selesai');
    $table->string('Nama_mapel', 100);
    $table->string('Alamat_siswa', 255);
    $table->timestamps();

    // Relasi
    $table->foreign('Id_siswa')->references('Id_siswa')->on('siswa')->onDelete('cascade');
    $table->foreign('Id_guru')->references('Id_guru')->on('guru')->onDelete('cascade');
    $table->foreign('Id_mapel')->references('Id_mapel')->on('mapel')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_bimbel');
    }
};
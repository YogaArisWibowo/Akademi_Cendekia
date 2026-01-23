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
        Schema::create('absensi_guru', function (Blueprint $table) {
    $table->unsignedInteger('Id_absensi_guru')->primary();
    $table->string('Id_guru', 10);
    $table->unsignedInteger('Id_jadwal_bimbel');
    $table->string('Bukti_foto', 255);
    $table->string('Hari', 255);
    $table->time('Waktu');
    $table->date('Tanggal');
    $table->text('Laporan_kegiatan');
    $table->dateTime('Created_up');
    $table->timestamps();

    $table->foreign('Id_guru')->references('Id_guru')->on('guru')->onDelete('cascade');
    $table->foreign('Id_jadwal_bimbel')->references('Id_jadwal_bimbel')->on('jadwal_bimbel')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_guru');
    }
};
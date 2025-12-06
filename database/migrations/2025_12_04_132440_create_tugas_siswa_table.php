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
        Schema::create('tugas_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru')->constrained('guru')->onDelete('cascade');
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_mapel')->constrained('mapel')->onDelete('cascade');
            $table->foreignId('id_jadwal_bimbel')->constrained('jadwal_bimbel')->onDelete('cascade');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('alamat_siswa',255);
            $table->char('nama_mapel',50);
            $table->string('penugasan',255);
            $table->string('jawaban_siswa');
            $table->float('nilai_tugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_siswa');
    }
};

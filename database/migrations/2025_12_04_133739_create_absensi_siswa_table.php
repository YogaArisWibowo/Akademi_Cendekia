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
            $table->id();
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_jadwal_bimbel')->constrained('jadwal_bimbel')->onDelete('cascade');
            $table->enum('kehadiran', ['Hadir', 'Ijin', 'Sakit']);
            $table->string('hari');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('mapel',255);
            $table->text('catatan');
            $table->string('bukti',255);
            $table->timestamps();
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

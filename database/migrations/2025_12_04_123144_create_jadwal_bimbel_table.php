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
            $table->id();
            $table->foreignId('id_guru')->constrained('guru')->onDelete('cascade');
            $table->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_mapel')->constrained('mapel')->onDelete('cascade');
            $table->char('hari',20);
            $table->time('waktu_mulai');//untuk type data time dalam jam misal 08.30
            $table->time('waktu_selesai');
            $table->char('nama_mapel',100);
            $table->string('alamat_siswa',255);
            $table->timestamps();
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

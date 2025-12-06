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
        Schema::create('gaji_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_guru')->constrained('guru')->onDelete('cascade');
            $table->foreignId('id_absensi_guru')->constrained('absensi_guru')->onDelete('cascade');
            $table->integer('nominal_gaji');
            $table->enum('kehadiran', ['Sudah Terbayar', 'Ijin', 'Belum Terbayar']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_guru');
    }
};

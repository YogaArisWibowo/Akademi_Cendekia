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
        Schema::create('alumni', function (Blueprint $table) {
    $table->unsignedInteger('Id_alumni')->primary();
    $table->string('Id_siswa', 10);
    $table->string('Id_guru', 10);
    $table->dateTime('Tahun_nonaktif');
    $table->string('Hasil_capaian', 255);
    $table->timestamps();

    $table->foreign('Id_siswa')->references('Id_siswa')->on('siswa')->onDelete('cascade');
    $table->foreign('Id_guru')->references('Id_guru')->on('guru')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
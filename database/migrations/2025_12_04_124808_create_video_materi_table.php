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
       Schema::create('video_materi', function (Blueprint $table) {
    $table->unsignedInteger('Id_video')->primary();
    $table->string('Id_siswa', 10);
    $table->string('Id_guru', 10);
    $table->unsignedInteger('Id_mapel');
    $table->string('Link_video', 255);
    $table->string('Jenis_Kurikulum', 50);
    $table->string('Nama_materi', 100);
    $table->timestamps();

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
        Schema::dropIfExists('video_materi');
    }
};
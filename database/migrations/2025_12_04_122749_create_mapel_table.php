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
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->nullable()->constrained('siswa')->onDelete('cascade');
            $table->char('nama_mapel', 100);
            $table->string('jenis_kurikulum', 100);//varchar
            $table->string('kelas', 100);//varchar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel');
    }
};

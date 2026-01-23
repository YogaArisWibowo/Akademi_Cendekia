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
    $table->unsignedInteger('Id_mapel')->primary();
    $table->string('Nama_mapel', 100);
    $table->string('Id_kurikulum', 50);
    $table->string('Kelas', 20);
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
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
    $table->unsignedInteger('Id_gaji_guru')->primary();
    $table->string('Id_guru', 10);
    $table->unsignedInteger('Id_absensi_guru');
    $table->bigInteger('Nominal_gaji');
    $table->bigInteger('gaji_perjam');
    $table->enum('Status_gaji', ['sudah', 'belum']);
    $table->timestamps();

    $table->foreign('Id_guru')->references('Id_guru')->on('guru')->onDelete('cascade');
    $table->foreign('Id_absensi_guru')->references('Id_absensi_guru')->on('absensi_guru')->onDelete('cascade');
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
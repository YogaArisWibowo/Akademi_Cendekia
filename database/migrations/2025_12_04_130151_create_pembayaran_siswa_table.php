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
        Schema::create('pembayaran_siswa', function (Blueprint $table) {
    $table->unsignedInteger('Id_pembayaran')->primary();
    $table->string('Id_siswa', 10);
    $table->dateTime('Tanggal_pembayaran');
    $table->char('Nama_ortu', 50);
    $table->bigInteger('Nominal');
    $table->string('Bukti_pembayaran', 255);
    $table->timestamps();

    $table->foreign('Id_siswa')->references('Id_siswa')->on('siswa')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_siswa');
    }
};
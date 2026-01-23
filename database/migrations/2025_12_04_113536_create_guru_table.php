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
        Schema::create('guru', function (Blueprint $table) {
    $table->string('Id_guru', 10)->primary();
    $table->string('Id_user', 10);
    $table->string('Nama', 50);
    $table->string('Mapel', 50);
    $table->string('Pendidikan_terakhir', 50);
    $table->bigInteger('No_hp');
    $table->string('Alamat_guru', 255);
    $table->string('Rekening', 50);
    $table->string('Jenis_e-wallet', 20);
    $table->bigInteger('No_e-wallet');
    $table->enum('Status_aktif', ['aktif', 'non-aktif']);
    $table->timestamps();

    // Relasi ke Users
    $table->foreign('Id_user')->references('Id_user')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
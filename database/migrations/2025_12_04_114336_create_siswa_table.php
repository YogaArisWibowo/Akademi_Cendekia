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
        Schema::create('siswa', function (Blueprint $table) {
    $table->string('Id_siswa', 10)->primary();
    $table->string('Id_user', 10);
    $table->string('Nama', 50);
    $table->string('Jenjang', 20);
    $table->string('Asal_sekolah', 50);
    $table->string('Kelas', 20);
    $table->bigInteger('No_hp_siswa');
    $table->string('Alamat_siswa', 255);
    $table->string('Nama_ortu', 50);
    $table->bigInteger('No_hp_ortu');
    $table->enum('Status_penerimaan', ['diterima', 'tertunda']);
    $table->enum('Status_aktif', ['aktif', 'non-aktif']);
    $table->timestamps();

    $table->foreign('Id_user')->references('Id_user')->on('users')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
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
            $table->id();
            $table->char('nama',50);
            $table->string('email', 50);// VARCHAR
            $table->string('password', 8);// VARCHAR
            $table->char('jenjang',20);
            $table->string('kelas', 20);// VARCHAR
            $table->string('asal_sekolah', 100);// VARCHAR
            $table->string('no_hp', 14);// VARCHAR
            $table->enum('status_penerimaan', ['Diterima', 'ditolak']);
            $table->enum('status_aktif', ['Aktif', 'Non-Aktif']);
            $table->timestamps();
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

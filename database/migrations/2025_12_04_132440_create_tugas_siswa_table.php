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
        Schema::create('tugas_siswa', function (Blueprint $table) {
            $table->string('Id_tugas', 10)->primary();
            
            // Foreign Keys Columns
            $table->string('Id_siswa', 10);
            $table->string('Id_guru', 10);
            
            // PERBAIKAN 1: Gunakan unsignedInteger agar cocok dengan tabel 'mapel'
            $table->unsignedInteger('Id_mapel'); 
            
            $table->unsignedInteger('Id_jadwal_bimbel');

            // PERBAIKAN 2: Hapus angka 10. Integer di Laravel tidak butuh parameter panjang.
            $table->integer('Waktu_mulai');
            $table->integer('Waktu_selesai');

            $table->char('Nama_mapel', 100);
            $table->string('file', 255);
            $table->string('Alamat_siswa', 255);
            $table->string('Penugasan', 255);
            $table->string('Jawaban_siswa', 255)->nullable(); // Tambah nullable jika siswa belum jawab
            $table->float('Nilai_tugas')->nullable(); // Tambah nullable jika belum dinilai
            $table->dateTime('Created_up');
            $table->timestamps();

            // DEFINISI RELASI (FOREIGN KEYS)
            $table->foreign('Id_siswa')->references('Id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('Id_guru')->references('Id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('Id_jadwal_bimbel')->references('Id_jadwal_bimbel')->on('jadwal_bimbel')->onDelete('cascade');
            
            // PERBAIKAN 3: Menambahkan relasi ke mapel yang tadi belum ada
            $table->foreign('Id_mapel')->references('Id_mapel')->on('mapel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_siswa');
    }
};
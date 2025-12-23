<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            // Menambahkan kolom nama_orang_tua setelah kolom asal_sekolah
            $table->string('nama_orang_tua')->nullable()->after('asal_sekolah');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('nama_orang_tua');
        });
    }
};
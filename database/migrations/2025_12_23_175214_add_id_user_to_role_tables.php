<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan id_user ke tabel Admin
        Schema::table('admin', function (Blueprint $table) {
            // Kita gunakan after('id') agar posisi kolom rapi di depan
            $table->foreignId('id_user')->after('id')->constrained('users')->onDelete('cascade');
        });

        // Menambahkan id_user ke tabel Guru
        Schema::table('guru', function (Blueprint $table) {
            $table->foreignId('id_user')->after('id')->constrained('users')->onDelete('cascade');
        });

        // Menambahkan id_user ke tabel Siswa
        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId('id_user')->after('id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });
        
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });
    }
};
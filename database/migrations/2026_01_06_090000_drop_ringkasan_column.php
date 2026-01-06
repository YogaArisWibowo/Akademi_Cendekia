<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Eksekusi: php artisan migrate
     * Fungsi: Menghapus kolom 'ringkasan'
     */
    public function up(): void
    {
        Schema::table('materi_pembelajaran', function (Blueprint $table) {
            // Menghapus kolom ringkasan
            $table->dropColumn('ringkasan');
        });
    }

    /**
     * Reverse the migrations.
     * Eksekusi: php artisan migrate:rollback
     * Fungsi: Mengembalikan kolom 'ringkasan' (jika dibatalkan)
     */
    public function down(): void
    {
        Schema::table('materi_pembelajaran', function (Blueprint $table) {
            // Tambahkan kembali kolom jika di-rollback
            $table->text('ringkasan')->nullable()->after('nama_materi');
        });
    }
};
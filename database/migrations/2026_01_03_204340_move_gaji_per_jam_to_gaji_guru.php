<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    // 1. Tambah kolom gaji_per_jam ke tabel gaji_guru
    Schema::table('gaji_guru', function (Blueprint $table) {
        $table->integer('gaji_per_jam')->default(0)->after('id_absensi_guru');
    });

    // 2. Hapus kolom gaji_per_jam dari tabel guru (opsional agar bersih)
    Schema::table('guru', function (Blueprint $table) {
        $table->dropColumn('gaji_per_jam');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaji_guru', function (Blueprint $table) {
            //
        });
    }
};

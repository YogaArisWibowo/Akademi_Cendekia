<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('guru', function (Blueprint $table) {
        // Mengubah nama kolom dari strip ke underscore
        $table->renameColumn('jenis_e-wallet', 'jenis_e_wallet');
        $table->renameColumn('no_e-wallet', 'no_e_wallet');
    });
}
};

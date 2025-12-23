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
            $table->id();
            $table->foreignId('id_user')->constrained('user')->onDelete('cascade');
            $table->char('nama', 50);
            $table->string('email', 50);// VARCHAR
            $table->string('password', 8);// VARCHAR
            $table->string('pendidikan_terakhir', 50);// VARCHAR
            $table->char('mapel', 50);
            $table->string('no_hp', 14); // VARCHAR(14)
            $table->string('alamat_guru', 255); // VARCHAR
            $table->string('rekening', 50); // VARCHAR
            $table->string('jenis_e-wallet', 50); // VARCHAR
            $table->string('no_e-wallet', 50); // VARCHAR
            $table->enum('status_aktif', ['Aktif', 'Non-Aktif']);
            $table->timestamps();
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

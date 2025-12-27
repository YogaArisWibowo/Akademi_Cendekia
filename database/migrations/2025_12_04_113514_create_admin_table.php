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
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            // Ubah 'user' menjadi 'users'
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('username', 50);
            $table->string('password', 8); // Hati-hati, password hash biasanya butuh 60+ karakter (string default 255)
=======
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('username');
            $table->string('nama');
>>>>>>> e5e5dc46417bbbae78796b7c3b2407d398da6b95
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};

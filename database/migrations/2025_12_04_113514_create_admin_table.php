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
    $table->string('Id_admin', 10)->primary();
    $table->string('Id_User', 10);
    $table->string('Username', 50);
    $table->string('Password', 8);
    $table->timestamps();

    // Relasi ke Users
    $table->foreign('Id_User')->references('Id_user')->on('users')->onDelete('cascade');
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
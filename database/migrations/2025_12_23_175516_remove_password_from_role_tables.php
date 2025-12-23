<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('password');
        });

        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn('password');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }

    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->string('password');
        });

        Schema::table('guru', function (Blueprint $table) {
            $table->string('password');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->string('password');
        });
    }
};
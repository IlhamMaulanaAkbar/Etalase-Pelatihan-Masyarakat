<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Gunakan raw SQL karena enum tidak bisa dimodifikasi langsung dengan Blueprint
        DB::statement("ALTER TABLE users MODIFY gender ENUM('Laki-laki', 'Perempuan') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan menjadi NOT NULL (tanpa nilai NULL diizinkan)
        DB::statement("ALTER TABLE users MODIFY gender ENUM('Laki-laki', 'Perempuan') NOT NULL");
    }
};

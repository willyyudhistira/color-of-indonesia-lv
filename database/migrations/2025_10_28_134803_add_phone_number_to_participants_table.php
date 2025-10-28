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
        Schema::table('participants', function (Blueprint $table) {
            // Tambahkan kolom 'phone_number' setelah kolom 'email'
            // Dibuat nullable() agar data lama tidak error
            $table->string('phone_number')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            // Hapus kolom 'phone_number' jika migrasi di-rollback
            $table->dropColumn('phone_number');
        });
    }
};
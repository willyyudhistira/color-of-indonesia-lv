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
        Schema::table('event_scheduled', function (Blueprint $table) {
            // 1. Hapus Foreign Key terlebih dahulu (PENTING)
            // Laravel biasanya menamai index foreign key sebagai: nama_tabel_nama_kolom_foreign
            $table->dropForeign(['certificate_template_id']);

            // 2. Hapus Kolom
            $table->dropColumn('certificate_template_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_scheduled', function (Blueprint $table) {
            // Mengembalikan kolom jika di-rollback
            $table->foreignId('certificate_template_id')
                  ->nullable()
                  ->constrained('certificate_templates')
                  ->nullOnDelete();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            // Tambahkan kolom baru setelah signature2
            $table->string('signature3_name')->nullable()->after('signature2_title');
            $table->string('signature3_title')->nullable()->after('signature3_name');
            $table->string('signature3_image')->nullable()->after('signature3_title');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->dropColumn(['signature3_name', 'signature3_title', 'signature3_image']);
        });
    }
};
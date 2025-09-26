<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_scheduled', function (Blueprint $table) {
            $table->foreignId('certificate_template_id')->nullable()->constrained('certificate_templates')->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_scheduled', function (Blueprint $table) {
            //
        });
    }
};

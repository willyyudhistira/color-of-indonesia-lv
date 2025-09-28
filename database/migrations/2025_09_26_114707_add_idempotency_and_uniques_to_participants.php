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
            if (!Schema::hasColumn('participants', 'external_submission_id')) {
                $table->string('external_submission_id')->nullable()->unique()->after('id');
            }
            $table->index('event_id');      // bantu performa filter
            $table->index('email');         // bantu pencarian
            $table->unique(['event_id','email']); // cegah email ganda pada event yang sama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropUnique(['participants_event_id_email_unique']);
            $table->dropIndex(['participants_event_id_index']);
            $table->dropIndex(['participants_email_index']);
            $table->dropUnique(['participants_external_submission_id_unique']);
            $table->dropColumn('external_submission_id');
        });
    }
};

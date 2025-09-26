<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->text('body_text')->nullable()->after('template_name');
            $table->text('winner_text')->nullable()->after('body_text');
            $table->text('supporting_text')->nullable()->after('winner_text');
            $table->text('participant_text')->nullable()->after('supporting_text');
        });
    }

    public function down(): void
    {
        Schema::table('certificate_templates', function (Blueprint $table) {
            $table->dropColumn(['body_text', 'winner_text', 'supporting_text', 'participant_text']);
        });
    }
};
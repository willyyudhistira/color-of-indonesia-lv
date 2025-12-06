<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            // Menambahkan foreign key ke tabel certificate_templates
            $table->foreignId('certificate_template_id')
                ->nullable() // Boleh null dulu untuk data lama
                ->after('event_id')
                ->constrained('certificate_templates')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign(['certificate_template_id']);
            $table->dropColumn('certificate_template_id');
        });
    }
};

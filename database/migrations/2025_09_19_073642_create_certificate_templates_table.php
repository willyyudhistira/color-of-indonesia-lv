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
    Schema::create('certificate_templates', function (Blueprint $table) {
        $table->id();
        $table->string('template_name');
        $table->string('background_image')->nullable();
        // Kolom untuk 7 logo di header
        $table->string('logo1')->nullable();
        $table->string('logo2')->nullable();
        $table->string('logo3')->nullable();
        $table->string('logo4')->nullable();
        $table->string('logo5')->nullable();
        $table->string('logo6')->nullable();
        $table->string('logo7')->nullable();
        // Kolom untuk Tanda Tangan 1
        $table->string('signature1_image')->nullable();
        $table->string('signature1_name')->nullable();
        $table->string('signature1_title')->nullable();
        // Kolom untuk Tanda Tangan 2
        $table->string('signature2_image')->nullable();
        $table->string('signature2_name')->nullable();
        $table->string('signature2_title')->nullable();
        // Kolom untuk logo di tengah tanda tangan
        $table->string('center_logo')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};

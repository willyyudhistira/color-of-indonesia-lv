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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('event_scheduled')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('certificate_number')->unique(); // Nomor unik untuk verifikasi
            $table->string('purpose')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('group')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 120);
            $table->string('phone', 30)->nullable();
            $table->text('message');
            $table->string('status')->default('new');
            // Sesuai skema Prisma, hanya ada created_at
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
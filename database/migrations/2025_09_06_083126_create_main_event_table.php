<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_event', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->text('subtitle');
            $table->text('description')->nullable();
            $table->string('location_name', 150)->nullable();
            $table->string('address')->nullable();
            $table->string('hero_image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_event');
    }
};
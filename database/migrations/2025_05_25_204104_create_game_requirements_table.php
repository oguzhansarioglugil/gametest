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
        Schema::create('game_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->enum('type', ['minimum', 'recommended']); // Minimum veya önerilen
            $table->foreignId('cpu_id')->constrained('hardware_models')->onDelete('cascade');
            $table->foreignId('gpu_id')->constrained('hardware_models')->onDelete('cascade');
            $table->integer('ram'); // GB cinsinden RAM
            $table->integer('disk'); // GB cinsinden disk alanı
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_requirements');
    }
};

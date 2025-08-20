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
        Schema::create('game_requirements_cpus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_requirement_id')->constrained('game_requirements')->onDelete('cascade');
            $table->foreignId('cpu_id')->constrained('hardware_models')->onDelete('cascade');
            $table->timestamps();

            // Aynı gereksinim için aynı CPU'nun tekrar eklenmesini önle
            $table->unique(['game_requirement_id', 'cpu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_requirements_cpus');
    }
};

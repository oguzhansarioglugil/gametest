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
        Schema::create('hardware_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('hardware_brands')->onDelete('cascade');
            $table->string('name'); // Ryzen 5 3600, i5-10400F, RTX 3060
            $table->enum('type', ['cpu', 'gpu']); // CPU veya GPU modeli
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_models');
    }
};

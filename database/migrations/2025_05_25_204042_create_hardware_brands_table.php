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
        Schema::create('hardware_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Intel, AMD, Nvidia
            $table->enum('type', ['cpu', 'gpu']); // CPU veya GPU markası
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_brands');
    }
};

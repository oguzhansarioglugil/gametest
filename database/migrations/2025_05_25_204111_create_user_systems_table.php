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
        Schema::create('user_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name')->default('Sistem 1'); // Sistem adı
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
        Schema::dropIfExists('user_systems');
    }
};

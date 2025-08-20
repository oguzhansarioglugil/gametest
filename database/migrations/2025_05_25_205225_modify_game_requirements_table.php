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
        Schema::table('game_requirements', function (Blueprint $table) {
            $table->dropForeign(['cpu_id']);
            $table->dropForeign(['gpu_id']);
            $table->dropColumn(['cpu_id', 'gpu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_requirements', function (Blueprint $table) {
            $table->foreignId('cpu_id')->constrained('hardware_models')->onDelete('cascade');
            $table->foreignId('gpu_id')->constrained('hardware_models')->onDelete('cascade');
        });
    }
};

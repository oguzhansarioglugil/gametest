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
        Schema::table('hardware_models', function (Blueprint $table) {
            $table->integer('benchmark_score')->nullable()->after('type')->comment('Benchmark puanı (PassMark vb.)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hardware_models', function (Blueprint $table) {
            $table->dropColumn('benchmark_score');
        });
    }
};

<?php

namespace Database\Seeders;

use App\Models\HardwareBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HardwareBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            // CPU Markaları
            ['name' => 'Intel', 'type' => 'cpu'],
            ['name' => 'AMD', 'type' => 'cpu'],

            // GPU Markaları
            ['name' => 'Nvidia', 'type' => 'gpu'],
            ['name' => 'AMD', 'type' => 'gpu'],
            ['name' => 'Intel', 'type' => 'gpu'],
        ];

        foreach ($brands as $brand) {
            HardwareBrand::create($brand);
        }
    }
}

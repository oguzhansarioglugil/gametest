<?php

namespace Database\Seeders;

use App\Models\HardwareBrand;
use App\Models\HardwareModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HardwareModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CPU Modelleri
        $intelCpu = HardwareBrand::where('name', 'Intel')->where('type', 'cpu')->first();
        $amdCpu = HardwareBrand::where('name', 'AMD')->where('type', 'cpu')->first();

        $cpuModels = [
            // Intel CPU'lar
            ['brand_id' => $intelCpu->id, 'name' => 'Core i3-10100F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i5-10400F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i5-11400F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i5-12400F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i7-10700F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i7-11700F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i7-12700F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i9-10900F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i9-11900F', 'type' => 'cpu'],
            ['brand_id' => $intelCpu->id, 'name' => 'Core i9-12900F', 'type' => 'cpu'],

            // AMD CPU'lar
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 3 3100', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 5 3600', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 5 5600X', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 7 3700X', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 7 5700X', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 7 5800X', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 9 3900X', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 9 5900X', 'type' => 'cpu'],
            ['brand_id' => $amdCpu->id, 'name' => 'Ryzen 9 5950X', 'type' => 'cpu'],
        ];

        // GPU Modelleri
        $nvidiaGpu = HardwareBrand::where('name', 'Nvidia')->where('type', 'gpu')->first();
        $amdGpu = HardwareBrand::where('name', 'AMD')->where('type', 'gpu')->first();
        $intelGpu = HardwareBrand::where('name', 'Intel')->where('type', 'gpu')->first();

        $gpuModels = [
            // Nvidia GPU'lar
            ['brand_id' => $nvidiaGpu->id, 'name' => 'GTX 1050 Ti', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'GTX 1060 6GB', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'GTX 1660', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'GTX 1660 Super', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 2060', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 2070', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 3060', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 3060 Ti', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 3070', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 3080', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 4060', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 4070', 'type' => 'gpu'],
            ['brand_id' => $nvidiaGpu->id, 'name' => 'RTX 4080', 'type' => 'gpu'],

            // AMD GPU'lar
            ['brand_id' => $amdGpu->id, 'name' => 'RX 570', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 580', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 5500 XT', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 5600 XT', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 6600', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 6600 XT', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 6700 XT', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 6800', 'type' => 'gpu'],
            ['brand_id' => $amdGpu->id, 'name' => 'RX 6800 XT', 'type' => 'gpu'],

            // Intel GPU'lar
            ['brand_id' => $intelGpu->id, 'name' => 'Arc A380', 'type' => 'gpu'],
            ['brand_id' => $intelGpu->id, 'name' => 'Arc A750', 'type' => 'gpu'],
            ['brand_id' => $intelGpu->id, 'name' => 'Arc A770', 'type' => 'gpu'],
        ];

        foreach ($cpuModels as $model) {
            HardwareModel::create($model);
        }

        foreach ($gpuModels as $model) {
            HardwareModel::create($model);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HardwareBrand;
use App\Models\HardwareModel;

class ExtendedHardwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mevcut brand'leri al
        $intelCpu = HardwareBrand::where('name', 'Intel')->where('type', 'cpu')->first();
        $amdCpu = HardwareBrand::where('name', 'AMD')->where('type', 'cpu')->first();
        $intelGpu = HardwareBrand::where('name', 'Intel')->where('type', 'gpu')->first();
        $amdGpu = HardwareBrand::where('name', 'AMD')->where('type', 'gpu')->first();
        $nvidia = HardwareBrand::where('name', 'Nvidia')->first();

        // Yeni CPU modelleri - Intel
        $intelCpus = [
            // 13th Gen (Raptor Lake)
            'Intel Core i9-13900K',
            'Intel Core i9-13900KF',
            'Intel Core i9-13900',
            'Intel Core i9-13900F',
            'Intel Core i7-13700K',
            'Intel Core i7-13700KF',
            'Intel Core i7-13700',
            'Intel Core i7-13700F',
            'Intel Core i5-13600K',
            'Intel Core i5-13600KF',
            'Intel Core i5-13600',
            'Intel Core i5-13500',
            'Intel Core i5-13400',
            'Intel Core i5-13400F',
            'Intel Core i3-13100',
            'Intel Core i3-13100F',

            // 12th Gen (Alder Lake)
            'Intel Core i9-12900K',
            'Intel Core i9-12900KF',
            'Intel Core i9-12900',
            'Intel Core i9-12900F',
            'Intel Core i7-12700K',
            'Intel Core i7-12700KF',
            'Intel Core i7-12700',
            'Intel Core i7-12700F',
            'Intel Core i5-12600K',
            'Intel Core i5-12600KF',
            'Intel Core i5-12600',
            'Intel Core i5-12500',
            'Intel Core i5-12400',
            'Intel Core i5-12400F',
            'Intel Core i3-12100',
            'Intel Core i3-12100F',

            // 11th Gen (Rocket Lake)
            'Intel Core i9-11900K',
            'Intel Core i9-11900KF',
            'Intel Core i7-11700K',
            'Intel Core i7-11700KF',
            'Intel Core i7-11700',
            'Intel Core i7-11700F',
            'Intel Core i5-11600K',
            'Intel Core i5-11600KF',
            'Intel Core i5-11500',
            'Intel Core i5-11400',
            'Intel Core i5-11400F',

            // 10th Gen (Comet Lake)
            'Intel Core i9-10900K',
            'Intel Core i9-10900KF',
            'Intel Core i9-10900',
            'Intel Core i9-10900F',
            'Intel Core i7-10700K',
            'Intel Core i7-10700KF',
            'Intel Core i7-10700',
            'Intel Core i7-10700F',
            'Intel Core i5-10600K',
            'Intel Core i5-10600KF',
            'Intel Core i5-10500',
            'Intel Core i5-10400',
            'Intel Core i5-10400F',
            'Intel Core i3-10320',
            'Intel Core i3-10300',
            'Intel Core i3-10100',
            'Intel Core i3-10100F',
        ];

        // Yeni CPU modelleri - AMD
        $amdCpus = [
            // Ryzen 7000 Series (Zen 4)
            'AMD Ryzen 9 7950X',
            'AMD Ryzen 9 7900X',
            'AMD Ryzen 7 7700X',
            'AMD Ryzen 5 7600X',
            'AMD Ryzen 9 7950X3D',
            'AMD Ryzen 9 7900X3D',
            'AMD Ryzen 7 7700X3D',
            'AMD Ryzen 7 7800X3D',

            // Ryzen 6000 Series (APU)
            'AMD Ryzen 7 6800H',
            'AMD Ryzen 5 6600H',
            'AMD Ryzen 7 6700S',
            'AMD Ryzen 5 6500S',

            // Ryzen 5000 Series (Zen 3)
            'AMD Ryzen 9 5950X',
            'AMD Ryzen 9 5900X',
            'AMD Ryzen 7 5800X',
            'AMD Ryzen 7 5700X',
            'AMD Ryzen 5 5600X',
            'AMD Ryzen 5 5500',
            'AMD Ryzen 9 5900',
            'AMD Ryzen 7 5800',
            'AMD Ryzen 7 5700G',
            'AMD Ryzen 5 5600G',
            'AMD Ryzen 5 5600',
            'AMD Ryzen 3 5300G',

            // Ryzen 4000 Series
            'AMD Ryzen 7 4700G',
            'AMD Ryzen 5 4600G',
            'AMD Ryzen 3 4300G',

            // Ryzen 3000 Series (Zen 2)
            'AMD Ryzen 9 3950X',
            'AMD Ryzen 9 3900X',
            'AMD Ryzen 7 3800X',
            'AMD Ryzen 7 3700X',
            'AMD Ryzen 5 3600X',
            'AMD Ryzen 5 3600',
            'AMD Ryzen 5 3500X',
            'AMD Ryzen 3 3300X',
            'AMD Ryzen 3 3200G',

            // Ryzen 2000 Series (Zen+)
            'AMD Ryzen 7 2700X',
            'AMD Ryzen 7 2700',
            'AMD Ryzen 5 2600X',
            'AMD Ryzen 5 2600',
            'AMD Ryzen 5 2500X',
            'AMD Ryzen 5 2400G',
            'AMD Ryzen 3 2300X',
            'AMD Ryzen 3 2200G',

            // Ryzen 1000 Series (Zen)
            'AMD Ryzen 7 1800X',
            'AMD Ryzen 7 1700X',
            'AMD Ryzen 7 1700',
            'AMD Ryzen 5 1600X',
            'AMD Ryzen 5 1600',
            'AMD Ryzen 5 1500X',
            'AMD Ryzen 5 1400',
            'AMD Ryzen 3 1300X',
            'AMD Ryzen 3 1200',
        ];

        // Yeni GPU modelleri - NVIDIA
        $nvidiaGpus = [
            // RTX 40 Series (Ada Lovelace)
            'NVIDIA GeForce RTX 4090',
            'NVIDIA GeForce RTX 4080',
            'NVIDIA GeForce RTX 4070 Ti',
            'NVIDIA GeForce RTX 4070',
            'NVIDIA GeForce RTX 4060 Ti',
            'NVIDIA GeForce RTX 4060',

            // RTX 30 Series (Ampere)
            'NVIDIA GeForce RTX 3090 Ti',
            'NVIDIA GeForce RTX 3090',
            'NVIDIA GeForce RTX 3080 Ti',
            'NVIDIA GeForce RTX 3080',
            'NVIDIA GeForce RTX 3070 Ti',
            'NVIDIA GeForce RTX 3070',
            'NVIDIA GeForce RTX 3060 Ti',
            'NVIDIA GeForce RTX 3060',
            'NVIDIA GeForce RTX 3050',

            // RTX 20 Series (Turing)
            'NVIDIA GeForce RTX 2080 Ti',
            'NVIDIA GeForce RTX 2080 Super',
            'NVIDIA GeForce RTX 2080',
            'NVIDIA GeForce RTX 2070 Super',
            'NVIDIA GeForce RTX 2070',
            'NVIDIA GeForce RTX 2060 Super',
            'NVIDIA GeForce RTX 2060',

            // GTX 16 Series (Turing)
            'NVIDIA GeForce GTX 1660 Ti',
            'NVIDIA GeForce GTX 1660 Super',
            'NVIDIA GeForce GTX 1660',
            'NVIDIA GeForce GTX 1650 Super',
            'NVIDIA GeForce GTX 1650',

            // GTX 10 Series (Pascal)
            'NVIDIA GeForce GTX 1080 Ti',
            'NVIDIA GeForce GTX 1080',
            'NVIDIA GeForce GTX 1070 Ti',
            'NVIDIA GeForce GTX 1070',
            'NVIDIA GeForce GTX 1060 6GB',
            'NVIDIA GeForce GTX 1060 3GB',
            'NVIDIA GeForce GTX 1050 Ti',
            'NVIDIA GeForce GTX 1050',

            // GTX 900 Series (Maxwell)
            'NVIDIA GeForce GTX 980 Ti',
            'NVIDIA GeForce GTX 980',
            'NVIDIA GeForce GTX 970',
            'NVIDIA GeForce GTX 960',
            'NVIDIA GeForce GTX 950',

            // GTX 700 Series (Kepler)
            'NVIDIA GeForce GTX 780 Ti',
            'NVIDIA GeForce GTX 780',
            'NVIDIA GeForce GTX 770',
            'NVIDIA GeForce GTX 760',
            'NVIDIA GeForce GTX 750 Ti',
            'NVIDIA GeForce GTX 750',
        ];

        // Yeni GPU modelleri - AMD
        $amdGpus = [
            // RX 7000 Series (RDNA 3)
            'AMD Radeon RX 7900 XTX',
            'AMD Radeon RX 7900 XT',
            'AMD Radeon RX 7800 XT',
            'AMD Radeon RX 7700 XT',
            'AMD Radeon RX 7600',

            // RX 6000 Series (RDNA 2)
            'AMD Radeon RX 6950 XT',
            'AMD Radeon RX 6900 XT',
            'AMD Radeon RX 6800 XT',
            'AMD Radeon RX 6800',
            'AMD Radeon RX 6750 XT',
            'AMD Radeon RX 6700 XT',
            'AMD Radeon RX 6650 XT',
            'AMD Radeon RX 6600 XT',
            'AMD Radeon RX 6600',
            'AMD Radeon RX 6500 XT',
            'AMD Radeon RX 6400',

            // RX 5000 Series (RDNA)
            'AMD Radeon RX 5700 XT',
            'AMD Radeon RX 5700',
            'AMD Radeon RX 5600 XT',
            'AMD Radeon RX 5500 XT',

            // RX 500 Series (Polaris)
            'AMD Radeon RX 590',
            'AMD Radeon RX 580',
            'AMD Radeon RX 570',
            'AMD Radeon RX 560',
            'AMD Radeon RX 550',

            // RX 400 Series (Polaris)
            'AMD Radeon RX 480',
            'AMD Radeon RX 470',
            'AMD Radeon RX 460',

            // R9 300 Series
            'AMD Radeon R9 390X',
            'AMD Radeon R9 390',
            'AMD Radeon R9 380X',
            'AMD Radeon R9 380',
            'AMD Radeon R9 370X',
            'AMD Radeon R9 370',

            // R9 200 Series
            'AMD Radeon R9 295X2',
            'AMD Radeon R9 290X',
            'AMD Radeon R9 290',
            'AMD Radeon R9 280X',
            'AMD Radeon R9 280',
            'AMD Radeon R9 270X',
            'AMD Radeon R9 270',
        ];

        // Intel GPU modelleri
        $intelGpus = [
            // Arc Series (Xe-HPG)
            'Intel Arc A770',
            'Intel Arc A750',
            'Intel Arc A580',
            'Intel Arc A380',
            'Intel Arc A310',

            // Integrated Graphics
            'Intel UHD Graphics 770',
            'Intel UHD Graphics 730',
            'Intel Iris Xe Graphics',
            'Intel UHD Graphics 630',
            'Intel UHD Graphics 620',
            'Intel HD Graphics 530',
            'Intel HD Graphics 520',
        ];

        // CPU modellerini ekle
        foreach ($intelCpus as $cpuName) {
            HardwareModel::firstOrCreate([
                'name' => $cpuName,
                'brand_id' => $intelCpu->id,
                'type' => 'cpu'
            ]);
        }

        foreach ($amdCpus as $cpuName) {
            HardwareModel::firstOrCreate([
                'name' => $cpuName,
                'brand_id' => $amdCpu->id,
                'type' => 'cpu'
            ]);
        }

        // GPU modellerini ekle
        foreach ($nvidiaGpus as $gpuName) {
            HardwareModel::firstOrCreate([
                'name' => $gpuName,
                'brand_id' => $nvidia->id,
                'type' => 'gpu'
            ]);
        }

        foreach ($amdGpus as $gpuName) {
            HardwareModel::firstOrCreate([
                'name' => $gpuName,
                'brand_id' => $amdGpu->id,
                'type' => 'gpu'
            ]);
        }

        foreach ($intelGpus as $gpuName) {
            HardwareModel::firstOrCreate([
                'name' => $gpuName,
                'brand_id' => $intelGpu->id,
                'type' => 'gpu'
            ]);
        }

        $this->command->info('Extended hardware models seeded successfully!');
        $this->command->info('Total Intel CPUs: ' . count($intelCpus));
        $this->command->info('Total AMD CPUs: ' . count($amdCpus));
        $this->command->info('Total NVIDIA GPUs: ' . count($nvidiaGpus));
        $this->command->info('Total AMD GPUs: ' . count($amdGpus));
        $this->command->info('Total Intel GPUs: ' . count($intelGpus));
    }
}

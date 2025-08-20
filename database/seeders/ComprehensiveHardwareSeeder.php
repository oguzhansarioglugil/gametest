<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HardwareBrand;
use App\Models\HardwareModel;

class ComprehensiveHardwareSeeder extends Seeder
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

        // Intel CPU'lar - PassMark verilerine göre güncel modeller
        $intelCpus = [
            // 14th Gen (Raptor Lake Refresh)
            'Intel Core i9-14900KS',
            'Intel Core i9-14900K',
            'Intel Core i9-14900KF',
            'Intel Core i9-14900',
            'Intel Core i9-14900F',
            'Intel Core i7-14700K',
            'Intel Core i7-14700KF',
            'Intel Core i7-14700',
            'Intel Core i7-14700F',
            'Intel Core i5-14600K',
            'Intel Core i5-14600KF',
            'Intel Core i5-14600',
            'Intel Core i5-14500',
            'Intel Core i5-14400',
            'Intel Core i5-14400F',
            'Intel Core i3-14100',
            'Intel Core i3-14100F',

            // 13th Gen (Raptor Lake) - Ek modeller
            'Intel Core i9-13900KS',
            'Intel Core i7-13700T',
            'Intel Core i5-13600T',
            'Intel Core i5-13500T',
            'Intel Core i5-13400T',
            'Intel Core i3-13300',
            'Intel Core i3-13100T',

            // 12th Gen (Alder Lake) - Ek modeller
            'Intel Core i9-12900KS',
            'Intel Core i7-12700T',
            'Intel Core i5-12600T',
            'Intel Core i5-12500T',
            'Intel Core i5-12400T',
            'Intel Core i3-12300',
            'Intel Core i3-12100T',

            // Xeon Workstation Series
            'Intel Xeon W-3175X',
            'Intel Xeon W-3265',
            'Intel Xeon W-3245',
            'Intel Xeon W-2295',
            'Intel Xeon W-2275',
            'Intel Xeon W-2255',
            'Intel Xeon W-2235',
            'Intel Xeon W-2225',
            'Intel Xeon W-2195',
            'Intel Xeon W-2175',
            'Intel Xeon W-2155',
            'Intel Xeon W-2145',
            'Intel Xeon W-2135',
            'Intel Xeon W-2125',
            'Intel Xeon W-2104',

            // Core X Series
            'Intel Core i9-10980XE',
            'Intel Core i9-10940X',
            'Intel Core i9-10920X',
            'Intel Core i9-10900X',
            'Intel Core i7-10800X',
            'Intel Core i9-9980XE',
            'Intel Core i9-9960X',
            'Intel Core i9-9940X',
            'Intel Core i9-9920X',
            'Intel Core i9-9900X',
            'Intel Core i7-9800X',

            // Older Generations (Popular models)
            'Intel Core i9-9900KS',
            'Intel Core i9-9900K',
            'Intel Core i9-9900KF',
            'Intel Core i7-9700K',
            'Intel Core i7-9700KF',
            'Intel Core i5-9600K',
            'Intel Core i5-9600KF',
            'Intel Core i5-9400',
            'Intel Core i5-9400F',
            'Intel Core i3-9350K',
            'Intel Core i3-9100',
            'Intel Core i3-9100F',

            // 8th Gen
            'Intel Core i7-8700K',
            'Intel Core i7-8700',
            'Intel Core i5-8600K',
            'Intel Core i5-8500',
            'Intel Core i5-8400',
            'Intel Core i3-8350K',
            'Intel Core i3-8300',
            'Intel Core i3-8100',

            // 7th Gen
            'Intel Core i7-7700K',
            'Intel Core i7-7700',
            'Intel Core i5-7600K',
            'Intel Core i5-7500',
            'Intel Core i5-7400',
            'Intel Core i3-7350K',
            'Intel Core i3-7300',
            'Intel Core i3-7100',

            // 6th Gen
            'Intel Core i7-6700K',
            'Intel Core i7-6700',
            'Intel Core i5-6600K',
            'Intel Core i5-6500',
            'Intel Core i5-6400',
            'Intel Core i3-6320',
            'Intel Core i3-6300',
            'Intel Core i3-6100',
        ];

        // AMD CPU'lar - PassMark verilerine göre güncel modeller
        $amdCpus = [
            // Ryzen 9000 Series (Zen 5)
            'AMD Ryzen 9 9950X',
            'AMD Ryzen 9 9900X',
            'AMD Ryzen 7 9700X',
            'AMD Ryzen 5 9600X',

            // Ryzen 8000 Series (APU)
            'AMD Ryzen 7 8700G',
            'AMD Ryzen 5 8600G',
            'AMD Ryzen 5 8500G',
            'AMD Ryzen 3 8300G',

            // Ryzen 7000 Series (Zen 4) - Ek modeller
            'AMD Ryzen 9 7945HX',
            'AMD Ryzen 9 7940HS',
            'AMD Ryzen 7 7840HS',
            'AMD Ryzen 7 7735HS',
            'AMD Ryzen 5 7640HS',
            'AMD Ryzen 5 7535HS',

            // Threadripper Series
            'AMD Ryzen Threadripper PRO 7995WX',
            'AMD Ryzen Threadripper PRO 7985WX',
            'AMD Ryzen Threadripper PRO 7975WX',
            'AMD Ryzen Threadripper PRO 7965WX',
            'AMD Ryzen Threadripper PRO 7955WX',
            'AMD Ryzen Threadripper PRO 7945WX',
            'AMD Ryzen Threadripper 7980X',
            'AMD Ryzen Threadripper 7970X',
            'AMD Ryzen Threadripper 7960X',
            'AMD Ryzen Threadripper PRO 5995WX',
            'AMD Ryzen Threadripper PRO 5975WX',
            'AMD Ryzen Threadripper PRO 5965WX',
            'AMD Ryzen Threadripper PRO 5955WX',
            'AMD Ryzen Threadripper PRO 5945WX',
            'AMD Ryzen Threadripper 5990X',
            'AMD Ryzen Threadripper 5980X',
            'AMD Ryzen Threadripper 5970X',
            'AMD Ryzen Threadripper 5960X',

            // EPYC Server Series (Popular models)
            'AMD EPYC 9754',
            'AMD EPYC 9654',
            'AMD EPYC 9554',
            'AMD EPYC 9454',
            'AMD EPYC 9374F',
            'AMD EPYC 9354',
            'AMD EPYC 9254',
            'AMD EPYC 7763',
            'AMD EPYC 7713',
            'AMD EPYC 7663',
            'AMD EPYC 7643',
            'AMD EPYC 7573X',
            'AMD EPYC 7543',
            'AMD EPYC 7513',
            'AMD EPYC 7473X',
            'AMD EPYC 7453',
            'AMD EPYC 7413',
            'AMD EPYC 7343',
            'AMD EPYC 7313',

            // Ryzen 5000 Series - Ek modeller
            'AMD Ryzen 9 5980HS',
            'AMD Ryzen 9 5980HX',
            'AMD Ryzen 9 5900HS',
            'AMD Ryzen 9 5900HX',
            'AMD Ryzen 7 5800HS',
            'AMD Ryzen 7 5800H',
            'AMD Ryzen 7 5700U',
            'AMD Ryzen 5 5600HS',
            'AMD Ryzen 5 5600H',
            'AMD Ryzen 5 5600U',
            'AMD Ryzen 5 5500U',
            'AMD Ryzen 3 5400U',
            'AMD Ryzen 3 5300U',

            // Older Generations
            'AMD Ryzen 9 3900XT',
            'AMD Ryzen 7 3800XT',
            'AMD Ryzen 5 3600XT',
            'AMD Ryzen 7 2700E',
            'AMD Ryzen 5 2600E',
            'AMD Ryzen 3 2200GE',
            'AMD Ryzen 7 1700E',
            'AMD Ryzen 5 1600E',
            'AMD Ryzen 5 1500',
            'AMD Ryzen 3 1300',
            'AMD Ryzen 3 1200E',

            // FX Series (Legacy but still used)
            'AMD FX-9590',
            'AMD FX-9370',
            'AMD FX-8370',
            'AMD FX-8350',
            'AMD FX-8320',
            'AMD FX-8300',
            'AMD FX-6350',
            'AMD FX-6300',
            'AMD FX-4350',
            'AMD FX-4300',

            // A-Series APU
            'AMD A12-9800',
            'AMD A10-9700',
            'AMD A8-9600',
            'AMD A6-9500',
            'AMD A4-9120',
        ];

        // NVIDIA GPU'lar - TechPowerUp verilerine göre güncel modeller
        $nvidiaGpus = [
            // RTX 50 Series (Blackwell)
            'NVIDIA GeForce RTX 5090',
            'NVIDIA GeForce RTX 5080',
            'NVIDIA GeForce RTX 5070 Ti',
            'NVIDIA GeForce RTX 5070',
            'NVIDIA GeForce RTX 5060 Ti 16GB',
            'NVIDIA GeForce RTX 5060 Ti 8GB',
            'NVIDIA GeForce RTX 5060',

            // RTX 40 Series (Ada Lovelace) - Tam liste
            'NVIDIA GeForce RTX 4090 Ti',
            'NVIDIA GeForce RTX 4080 SUPER',
            'NVIDIA GeForce RTX 4070 Ti SUPER',
            'NVIDIA GeForce RTX 4070 SUPER',
            'NVIDIA GeForce RTX 4060 Ti 16GB',

            // RTX 30 Series (Ampere) - Ek modeller
            'NVIDIA GeForce RTX 3090 Ti',
            'NVIDIA GeForce RTX 3080 Ti',
            'NVIDIA GeForce RTX 3070 Ti',
            'NVIDIA GeForce RTX 3060 8GB',
            'NVIDIA GeForce RTX 3050 6GB',

            // RTX 20 Series (Turing) - Ek modeller
            'NVIDIA GeForce RTX 2080 SUPER',
            'NVIDIA GeForce RTX 2070 SUPER',
            'NVIDIA GeForce RTX 2060 12GB',
            'NVIDIA GeForce RTX 2060 SUPER',

            // GTX 16 Series (Turing) - Ek modeller
            'NVIDIA GeForce GTX 1660 Ti',
            'NVIDIA GeForce GTX 1660 SUPER',
            'NVIDIA GeForce GTX 1660',
            'NVIDIA GeForce GTX 1650 SUPER',
            'NVIDIA GeForce GTX 1650 Ti',
            'NVIDIA GeForce GTX 1650',
            'NVIDIA GeForce GTX 1630',

            // GTX 10 Series (Pascal) - Ek modeller
            'NVIDIA GeForce GTX 1080 Ti',
            'NVIDIA GeForce GTX 1080',
            'NVIDIA GeForce GTX 1070 Ti',
            'NVIDIA GeForce GTX 1070',
            'NVIDIA GeForce GTX 1060 6GB',
            'NVIDIA GeForce GTX 1060 3GB',
            'NVIDIA GeForce GTX 1050 Ti',
            'NVIDIA GeForce GTX 1050',
            'NVIDIA TITAN Xp',
            'NVIDIA TITAN X (Pascal)',

            // GTX 900 Series (Maxwell)
            'NVIDIA GeForce GTX 980 Ti',
            'NVIDIA GeForce GTX 980',
            'NVIDIA GeForce GTX 970',
            'NVIDIA GeForce GTX 960',
            'NVIDIA GeForce GTX 950',
            'NVIDIA TITAN X (Maxwell)',

            // GTX 700 Series (Kepler)
            'NVIDIA GeForce GTX 780 Ti',
            'NVIDIA GeForce GTX 780',
            'NVIDIA GeForce GTX 770',
            'NVIDIA GeForce GTX 760',
            'NVIDIA GeForce GTX 750 Ti',
            'NVIDIA GeForce GTX 750',
            'NVIDIA TITAN Black',
            'NVIDIA TITAN',

            // GTX 600 Series (Kepler)
            'NVIDIA GeForce GTX 690',
            'NVIDIA GeForce GTX 680',
            'NVIDIA GeForce GTX 670',
            'NVIDIA GeForce GTX 660 Ti',
            'NVIDIA GeForce GTX 660',
            'NVIDIA GeForce GTX 650 Ti',
            'NVIDIA GeForce GTX 650',

            // Quadro Professional Series
            'NVIDIA Quadro RTX 8000',
            'NVIDIA Quadro RTX 6000',
            'NVIDIA Quadro RTX 5000',
            'NVIDIA Quadro RTX 4000',
            'NVIDIA Quadro P6000',
            'NVIDIA Quadro P5000',
            'NVIDIA Quadro P4000',
            'NVIDIA Quadro P2000',
            'NVIDIA Quadro P1000',
            'NVIDIA Quadro P600',
            'NVIDIA Quadro P400',

            // Tesla Data Center Series
            'NVIDIA Tesla V100',
            'NVIDIA Tesla P100',
            'NVIDIA Tesla P40',
            'NVIDIA Tesla P4',
            'NVIDIA Tesla M60',
            'NVIDIA Tesla M40',
            'NVIDIA Tesla K80',
            'NVIDIA Tesla K40',
            'NVIDIA Tesla K20',

            // Mobile RTX Series
            'NVIDIA GeForce RTX 4090 Mobile',
            'NVIDIA GeForce RTX 4080 Mobile',
            'NVIDIA GeForce RTX 4070 Mobile',
            'NVIDIA GeForce RTX 4060 Mobile',
            'NVIDIA GeForce RTX 4050 Mobile',
            'NVIDIA GeForce RTX 3080 Ti Mobile',
            'NVIDIA GeForce RTX 3080 Mobile',
            'NVIDIA GeForce RTX 3070 Ti Mobile',
            'NVIDIA GeForce RTX 3070 Mobile',
            'NVIDIA GeForce RTX 3060 Mobile',
            'NVIDIA GeForce RTX 3050 Ti Mobile',
            'NVIDIA GeForce RTX 3050 Mobile',
        ];

        // AMD GPU'lar - TechPowerUp verilerine göre güncel modeller
        $amdGpus = [
            // RX 9000 Series (RDNA 4)
            'AMD Radeon RX 9070 XT',
            'AMD Radeon RX 9070',
            'AMD Radeon RX 9060 XT 16GB',
            'AMD Radeon RX 9060 XT 8GB',

            // RX 7000 Series (RDNA 3) - Ek modeller
            'AMD Radeon RX 7900 GRE',
            'AMD Radeon RX 7600 XT',

            // RX 6000 Series (RDNA 2) - Ek modeller
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

            // RX 5000 Series (RDNA) - Ek modeller
            'AMD Radeon RX 5700 XT',
            'AMD Radeon RX 5700',
            'AMD Radeon RX 5600 XT',
            'AMD Radeon RX 5500 XT 8GB',
            'AMD Radeon RX 5500 XT 4GB',
            'AMD Radeon RX 5500',

            // RX 500 Series (Polaris) - Ek modeller
            'AMD Radeon RX 590',
            'AMD Radeon RX 580 8GB',
            'AMD Radeon RX 580 4GB',
            'AMD Radeon RX 570 8GB',
            'AMD Radeon RX 570 4GB',
            'AMD Radeon RX 560 4GB',
            'AMD Radeon RX 560 2GB',
            'AMD Radeon RX 550 4GB',
            'AMD Radeon RX 550 2GB',

            // RX 400 Series (Polaris)
            'AMD Radeon RX 480 8GB',
            'AMD Radeon RX 480 4GB',
            'AMD Radeon RX 470 8GB',
            'AMD Radeon RX 470 4GB',
            'AMD Radeon RX 460 4GB',
            'AMD Radeon RX 460 2GB',

            // R9 300 Series
            'AMD Radeon R9 390X',
            'AMD Radeon R9 390',
            'AMD Radeon R9 380X',
            'AMD Radeon R9 380',
            'AMD Radeon R9 370X',
            'AMD Radeon R9 370',
            'AMD Radeon R7 360',
            'AMD Radeon R7 350',

            // R9 200 Series
            'AMD Radeon R9 295X2',
            'AMD Radeon R9 290X',
            'AMD Radeon R9 290',
            'AMD Radeon R9 280X',
            'AMD Radeon R9 280',
            'AMD Radeon R9 270X',
            'AMD Radeon R9 270',
            'AMD Radeon R7 260X',
            'AMD Radeon R7 260',
            'AMD Radeon R7 250X',
            'AMD Radeon R7 250',
            'AMD Radeon R7 240',

            // HD 7000 Series
            'AMD Radeon HD 7990',
            'AMD Radeon HD 7970 GHz Edition',
            'AMD Radeon HD 7970',
            'AMD Radeon HD 7950',
            'AMD Radeon HD 7870 XT',
            'AMD Radeon HD 7870',
            'AMD Radeon HD 7850',
            'AMD Radeon HD 7790',
            'AMD Radeon HD 7770',
            'AMD Radeon HD 7750',
            'AMD Radeon HD 7730',
            'AMD Radeon HD 7670',
            'AMD Radeon HD 7650',

            // Professional Series
            'AMD Radeon Pro W7900',
            'AMD Radeon Pro W7800',
            'AMD Radeon Pro W7700',
            'AMD Radeon Pro W7600',
            'AMD Radeon Pro W7500',
            'AMD Radeon Pro W6800',
            'AMD Radeon Pro W6600',
            'AMD Radeon Pro W6400',
            'AMD Radeon Pro W5700',
            'AMD Radeon Pro W5500',
            'AMD Radeon Pro WX 9100',
            'AMD Radeon Pro WX 8200',
            'AMD Radeon Pro WX 7100',
            'AMD Radeon Pro WX 5100',
            'AMD Radeon Pro WX 4100',
            'AMD Radeon Pro WX 3200',
            'AMD Radeon Pro WX 3100',
            'AMD Radeon Pro WX 2100',

            // Instinct Data Center Series
            'AMD Radeon Instinct MI300X',
            'AMD Radeon Instinct MI300A',
            'AMD Radeon Instinct MI250X',
            'AMD Radeon Instinct MI250',
            'AMD Radeon Instinct MI210',
            'AMD Radeon Instinct MI100',
            'AMD Radeon Instinct MI60',
            'AMD Radeon Instinct MI50',
            'AMD Radeon Instinct MI25',
            'AMD Radeon Instinct MI8',
            'AMD Radeon Instinct MI6',

            // Mobile RX Series
            'AMD Radeon RX 7900M',
            'AMD Radeon RX 7800M XT',
            'AMD Radeon RX 7700S',
            'AMD Radeon RX 7600M XT',
            'AMD Radeon RX 7600M',
            'AMD Radeon RX 6850M XT',
            'AMD Radeon RX 6800M',
            'AMD Radeon RX 6700M',
            'AMD Radeon RX 6650M XT',
            'AMD Radeon RX 6650M',
            'AMD Radeon RX 6600M',
            'AMD Radeon RX 6500M',
            'AMD Radeon RX 6300M',
        ];

        // Intel GPU'lar - TechPowerUp verilerine göre güncel modeller
        $intelGpus = [
            // Arc Battlemage Series (Xe2)
            'Intel Arc B580',
            'Intel Arc B570',

            // Arc Alchemist Series (Xe-HPG) - Ek modeller
            'Intel Arc A770 16GB',
            'Intel Arc A770 8GB',
            'Intel Arc A750',
            'Intel Arc A580',
            'Intel Arc A380',
            'Intel Arc A310',

            // Arc Mobile Series
            'Intel Arc A370M',
            'Intel Arc A350M',
            'Intel Arc A730M',
            'Intel Arc A550M',
            'Intel Arc A530M',
            'Intel Arc A370M',
            'Intel Arc A350M',

            // Integrated Graphics (Latest)
            'Intel UHD Graphics 770',
            'Intel UHD Graphics 730',
            'Intel Iris Xe Graphics G7 96EUs',
            'Intel Iris Xe Graphics G7 80EUs',
            'Intel UHD Graphics Xe G4 48EUs',
            'Intel UHD Graphics 630',
            'Intel UHD Graphics 620',
            'Intel UHD Graphics 610',
            'Intel HD Graphics 530',
            'Intel HD Graphics 520',
            'Intel HD Graphics 510',
            'Intel HD Graphics 4600',
            'Intel HD Graphics 4400',
            'Intel HD Graphics 4000',
            'Intel HD Graphics 3000',
            'Intel HD Graphics 2500',
            'Intel HD Graphics 2000',

            // Iris Graphics
            'Intel Iris Xe MAX Graphics',
            'Intel Iris Plus Graphics G7',
            'Intel Iris Plus Graphics G4',
            'Intel Iris Plus Graphics 655',
            'Intel Iris Plus Graphics 650',
            'Intel Iris Plus Graphics 645',
            'Intel Iris Plus Graphics 640',
            'Intel Iris Pro Graphics 6200',
            'Intel Iris Pro Graphics 5200',
            'Intel Iris Graphics 6100',
            'Intel Iris Graphics 5100',

            // Data Center GPU
            'Intel Data Center GPU Max 1550',
            'Intel Data Center GPU Max 1350',
            'Intel Data Center GPU Max 1100',
            'Intel Data Center GPU Flex 170',
            'Intel Data Center GPU Flex 140',

            // Legacy Graphics
            'Intel GMA X4500',
            'Intel GMA X3500',
            'Intel GMA X3100',
            'Intel GMA 950',
            'Intel GMA 900',
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

        $this->command->info('Comprehensive hardware models seeded successfully!');
        $this->command->info('Total Intel CPUs added: ' . count($intelCpus));
        $this->command->info('Total AMD CPUs added: ' . count($amdCpus));
        $this->command->info('Total NVIDIA GPUs added: ' . count($nvidiaGpus));
        $this->command->info('Total AMD GPUs added: ' . count($amdGpus));
        $this->command->info('Total Intel GPUs added: ' . count($intelGpus));

        // Toplam sayıları göster
        $totalCpus = HardwareModel::where('type', 'cpu')->count();
        $totalGpus = HardwareModel::where('type', 'gpu')->count();
        $this->command->info('=== DATABASE TOTALS ===');
        $this->command->info('Total CPUs in database: ' . $totalCpus);
        $this->command->info('Total GPUs in database: ' . $totalGpus);
        $this->command->info('Grand total hardware models: ' . ($totalCpus + $totalGpus));
    }
}

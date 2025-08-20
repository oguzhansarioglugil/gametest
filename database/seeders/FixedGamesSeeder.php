<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\GameRequirement;
use App\Models\HardwareModel;

class FixedGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'name' => 'Cyberpunk 2077 Enhanced',
                'description' => 'Gelecekte geçen açık dünya RPG oyunu. Night City\'de siber punk macerası yaşayın.',
                'score' => 8.5,
            ],
            [
                'name' => 'Elden Ring Deluxe',
                'description' => 'FromSoftware\'in açık dünya souls-like oyunu. Karanlık fantastik dünyada keşif.',
                'score' => 9.5,
            ],
            [
                'name' => 'Red Dead Redemption 2 Ultimate',
                'description' => 'Vahşi batıda geçen açık dünya aksiyon oyunu. Arthur Morgan\'ın hikayesi.',
                'score' => 9.2,
            ],
        ];

        // CPU ve GPU modellerini al - daha spesifik seçim
        $intelCpus = HardwareModel::where('type', 'cpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'Intel');
            })
            ->whereIn('name', [
                'Core i3-10100F', 'Core i5-8400', 'Core i5-10400F',
                'Core i7-8700K', 'Core i7-10700K', 'Core i9-9900K'
            ])
            ->get();

        $amdCpus = HardwareModel::where('type', 'cpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'AMD');
            })
            ->whereIn('name', [
                'Ryzen 3 3100', 'Ryzen 5 2600', 'Ryzen 5 3600',
                'Ryzen 7 3700X', 'Ryzen 7 5800X', 'Ryzen 9 5900X'
            ])
            ->get();

        $nvidiaGpus = HardwareModel::where('type', 'gpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'Nvidia');
            })
            ->whereIn('name', [
                'GTX 1060 6GB', 'GTX 1660', 'RTX 2060',
                'RTX 3060', 'RTX 3070', 'RTX 4070'
            ])
            ->get();

        $amdGpus = HardwareModel::where('type', 'gpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'AMD');
            })
            ->whereIn('name', [
                'RX 580', 'RX 5600 XT', 'RX 6600 XT',
                'RX 6700 XT', 'RX 7600', 'RX 7700 XT'
            ])
            ->get();

        foreach ($games as $gameData) {
            $game = Game::create($gameData);

            // Sabit disk alanı - oyun boyutu
            $diskSpace = rand(50, 100);

            // Minimum gereksinimler
            $minRequirement = GameRequirement::create([
                'game_id' => $game->id,
                'type' => 'minimum',
                'ram' => rand(8, 12),
                'disk' => $diskSpace, // Sabit disk alanı
            ]);

            // CPU seçenekleri - Intel ve AMD'den birer tane
            $selectedCpus = collect();
            if ($intelCpus->count() > 0) {
                $selectedCpus->push($intelCpus->random());
            }
            if ($amdCpus->count() > 0) {
                $selectedCpus->push($amdCpus->random());
            }
            $minRequirement->cpus()->attach($selectedCpus->pluck('id'));

            // GPU seçenekleri - NVIDIA ve AMD'den birer tane
            $selectedGpus = collect();
            if ($nvidiaGpus->count() > 0) {
                $selectedGpus->push($nvidiaGpus->random());
            }
            if ($amdGpus->count() > 0) {
                $selectedGpus->push($amdGpus->random());
            }
            $minRequirement->gpus()->attach($selectedGpus->pluck('id'));

            // Önerilen gereksinimler
            $recRequirement = GameRequirement::create([
                'game_id' => $game->id,
                'type' => 'recommended',
                'ram' => rand(16, 32),
                'disk' => $diskSpace, // Aynı disk alanı
            ]);

            // Daha güçlü CPU'lar - Intel ve AMD'den birer tane
            $selectedCpus = collect();
            if ($intelCpus->count() > 2) {
                $selectedCpus->push($intelCpus->skip(2)->random());
            }
            if ($amdCpus->count() > 2) {
                $selectedCpus->push($amdCpus->skip(2)->random());
            }
            $recRequirement->cpus()->attach($selectedCpus->pluck('id'));

            // Daha güçlü GPU'lar - NVIDIA ve AMD'den birer tane
            $selectedGpus = collect();
            if ($nvidiaGpus->count() > 2) {
                $selectedGpus->push($nvidiaGpus->skip(2)->random());
            }
            if ($amdGpus->count() > 2) {
                $selectedGpus->push($amdGpus->skip(2)->random());
            }
            $recRequirement->gpus()->attach($selectedGpus->pluck('id'));
        }

        $this->command->info('3 fixed games seeded successfully with proper GPU distribution!');
    }
}

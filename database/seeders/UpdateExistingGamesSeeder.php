<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\GameRequirement;
use App\Models\HardwareModel;

class UpdateExistingGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mevcut tüm oyunları al
        $games = Game::with(['requirements'])->get();

        // CPU ve GPU modellerini al
        $intelCpus = HardwareModel::where('type', 'cpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'Intel');
            })->take(15)->get();

        $amdCpus = HardwareModel::where('type', 'cpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'AMD');
            })->take(15)->get();

        $nvidiaGpus = HardwareModel::where('type', 'gpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'Nvidia');
            })->take(15)->get();

        $amdGpus = HardwareModel::where('type', 'gpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'AMD');
            })->take(15)->get();

        foreach ($games as $game) {
            // Mevcut gereksinimleri sil
            $game->requirements()->delete();

            // Sabit disk alanı - oyun boyutu
            $diskSpace = rand(30, 120);

            // Minimum gereksinimler
            $minRequirement = GameRequirement::create([
                'game_id' => $game->id,
                'type' => 'minimum',
                'ram' => rand(4, 8),
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
                'ram' => rand(8, 16),
                'disk' => $diskSpace, // Aynı disk alanı
            ]);

            // Daha güçlü CPU'lar - Intel ve AMD'den birer tane
            $selectedCpus = collect();
            if ($intelCpus->count() > 5) {
                $selectedCpus->push($intelCpus->skip(5)->random());
            }
            if ($amdCpus->count() > 5) {
                $selectedCpus->push($amdCpus->skip(5)->random());
            }
            $recRequirement->cpus()->attach($selectedCpus->pluck('id'));

            // Daha güçlü GPU'lar - NVIDIA ve AMD'den birer tane
            $selectedGpus = collect();
            if ($nvidiaGpus->count() > 5) {
                $selectedGpus->push($nvidiaGpus->skip(5)->random());
            }
            if ($amdGpus->count() > 5) {
                $selectedGpus->push($amdGpus->skip(5)->random());
            }
            $recRequirement->gpus()->attach($selectedGpus->pluck('id'));
        }

        $this->command->info('Updated ' . $games->count() . ' games with proper system requirements!');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\GameRequirement;
use App\Models\HardwareModel;

class MoreGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'name' => 'The Witcher 3: Wild Hunt',
                'description' => 'Açık dünya RPG oyunu. Geralt of Rivia olarak büyülü bir dünyada maceraya atılın.',
                'score' => 9.3,
            ],
            [
                'name' => 'Grand Theft Auto V',
                'description' => 'Los Santos şehrinde suç dolu bir hayat yaşayın. Çok oyunculu GTA Online modu ile.',
                'score' => 9.0,
            ],
            [
                'name' => 'Minecraft',
                'description' => 'Blok tabanlı sandbox oyunu. Hayal gücünüzün sınırlarını zorlayın.',
                'score' => 8.8,
            ],
            [
                'name' => 'Counter-Strike 2',
                'description' => 'Taktiksel FPS oyunu. Takım halinde stratejik savaşlar yapın.',
                'score' => 8.5,
            ],
            [
                'name' => 'Valorant',
                'description' => 'Riot Games\'in taktiksel FPS oyunu. Benzersiz ajanlar ve yetenekler.',
                'score' => 8.2,
            ],
            [
                'name' => 'Apex Legends',
                'description' => 'Battle royale oyunu. Takım halinde hayatta kalma mücadelesi.',
                'score' => 8.0,
            ],
            [
                'name' => 'Fortnite',
                'description' => 'Popüler battle royale oyunu. İnşa etme ve savaşma mekaniği.',
                'score' => 7.8,
            ],
            [
                'name' => 'League of Legends',
                'description' => 'MOBA oyunu. 5v5 takım savaşları ve stratejik oynanış.',
                'score' => 8.3,
            ],
            [
                'name' => 'Dota 2',
                'description' => 'Valve\'ın MOBA oyunu. Karmaşık mekanikler ve yüksek rekabet.',
                'score' => 8.1,
            ],
            [
                'name' => 'Call of Duty: Modern Warfare III',
                'description' => 'FPS oyunu serisi. Hızlı tempolu çok oyunculu savaşlar.',
                'score' => 7.5,
            ],
            [
                'name' => 'FIFA 24',
                'description' => 'Futbol simülasyon oyunu. Gerçekçi futbol deneyimi.',
                'score' => 7.9,
            ],
            [
                'name' => 'Assassin\'s Creed Mirage',
                'description' => 'Tarihi aksiyon-macera oyunu. Ortaçağ Bağdat\'ında suikastçı macerası.',
                'score' => 8.0,
            ],
            [
                'name' => 'Spider-Man Remastered',
                'description' => 'Süper kahraman aksiyon oyunu. New York\'da web-swinging macerası.',
                'score' => 8.7,
            ],
            [
                'name' => 'God of War',
                'description' => 'Aksiyon-macera oyunu. Kratos ve oğlu Atreus\'un İskandinav mitolojisi yolculuğu.',
                'score' => 9.1,
            ],
            [
                'name' => 'Horizon Zero Dawn',
                'description' => 'Post-apokaliptik açık dünya RPG. Robot dinozorlarla savaş.',
                'score' => 8.9,
            ],
            [
                'name' => 'Death Stranding',
                'description' => 'Hideo Kojima\'nın benzersiz aksiyon oyunu. Kargo teslimat mekaniği.',
                'score' => 8.2,
            ],
            [
                'name' => 'Sekiro: Shadows Die Twice',
                'description' => 'FromSoftware\'in zorlu aksiyon oyunu. Feudal Japonya\'da ninja macerası.',
                'score' => 9.0,
            ],
            [
                'name' => 'Dark Souls III',
                'description' => 'Zorlu aksiyon RPG. Karanlık fantastik dünyada hayatta kalma.',
                'score' => 8.8,
            ],
            [
                'name' => 'Bloodborne',
                'description' => 'Gothic korku temalı aksiyon RPG. Lovecraftian atmosfer.',
                'score' => 9.2,
            ],
            [
                'name' => 'Monster Hunter: World',
                'description' => 'Aksiyon RPG. Dev canavarları avlama odaklı co-op oyun.',
                'score' => 8.6,
            ],
            [
                'name' => 'Resident Evil 4',
                'description' => 'Survival horror oyunu. Leon Kennedy\'nin köy macerası.',
                'score' => 9.4,
            ],
            [
                'name' => 'Baldur\'s Gate 3',
                'description' => 'Turn-based RPG. D&D kurallarına dayalı derin hikaye.',
                'score' => 9.6,
            ],
            [
                'name' => 'Starfield',
                'description' => 'Bethesda\'nın uzay temalı RPG oyunu. Galaksi keşfi.',
                'score' => 7.8,
            ],
            [
                'name' => 'Diablo IV',
                'description' => 'Action RPG. Karanlık fantastik dünyada loot avcılığı.',
                'score' => 8.1,
            ],
            [
                'name' => 'Street Fighter 6',
                'description' => 'Dövüş oyunu. Klasik karakterler ve yeni mekanikler.',
                'score' => 8.4,
            ],
        ];

        // CPU ve GPU modellerini al
        $intelCpus = HardwareModel::where('type', 'cpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'Intel');
            })->take(10)->get();

        $amdCpus = HardwareModel::where('type', 'cpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'AMD');
            })->take(10)->get();

        $nvidiaGpus = HardwareModel::where('type', 'gpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'Nvidia');
            })->take(10)->get();

        $amdGpus = HardwareModel::where('type', 'gpu')
            ->whereHas('brand', function($q) {
                $q->where('name', 'AMD');
            })->take(10)->get();

        foreach ($games as $gameData) {
            $game = Game::create($gameData);

            // Minimum gereksinimler
            $minRequirement = GameRequirement::create([
                'game_id' => $game->id,
                'type' => 'minimum',
                'ram' => rand(4, 8),
                'disk' => rand(25, 50),
            ]);

            // Rastgele CPU'lar ekle (2-3 adet)
            $selectedCpus = collect()
                ->merge($intelCpus->random(rand(1, 2)))
                ->merge($amdCpus->random(rand(1, 2)));

            $minRequirement->cpus()->attach($selectedCpus->pluck('id'));

            // Rastgele GPU'lar ekle (2-3 adet)
            $selectedGpus = collect()
                ->merge($nvidiaGpus->random(rand(1, 2)))
                ->merge($amdGpus->random(rand(1, 2)));

            $minRequirement->gpus()->attach($selectedGpus->pluck('id'));

            // Önerilen gereksinimler
            $recRequirement = GameRequirement::create([
                'game_id' => $game->id,
                'type' => 'recommended',
                'ram' => rand(8, 16),
                'disk' => rand(50, 100),
            ]);

            // Daha güçlü CPU'lar
            $selectedCpus = collect()
                ->merge($intelCpus->random(rand(1, 2)))
                ->merge($amdCpus->random(rand(1, 2)));

            $recRequirement->cpus()->attach($selectedCpus->pluck('id'));

            // Daha güçlü GPU'lar
            $selectedGpus = collect()
                ->merge($nvidiaGpus->random(rand(1, 2)))
                ->merge($amdGpus->random(rand(1, 2)));

            $recRequirement->gpus()->attach($selectedGpus->pluck('id'));
        }

        $this->command->info('25 additional games seeded successfully!');
    }
}

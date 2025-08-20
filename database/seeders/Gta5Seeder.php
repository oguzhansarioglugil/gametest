<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameRequirement;
use App\Models\HardwareModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Gta5Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Grand Theft Auto V
        $gta5 = Game::create([
            'name' => 'Grand Theft Auto V',
            'description' => 'Los Santos şehrinde geçen açık dünya aksiyon-macera oyunu. Üç farklı karakterle suç dünyasında heyecan dolu görevler yapın. Online modu ile arkadaşlarınızla birlikte oynayın.',
            'image' => 'gta5.jpg',
            'score' => 9.0,
        ]);

        // GTA 5 Minimum Sistem Gereksinimleri
        $gta5Min = GameRequirement::create([
            'game_id' => $gta5->id,
            'type' => 'minimum',
            'ram' => 4,
            'disk' => 72,
        ]);

        // Minimum CPU seçenekleri (eski nesil CPU'lar)
        $gta5MinCpus = [
            HardwareModel::where('name', 'Core i3-10100F')->first()->id,
            HardwareModel::where('name', 'Ryzen 3 3100')->first()->id,
        ];
        $gta5Min->addCpus($gta5MinCpus);

        // Minimum GPU seçenekleri (entry-level GPU'lar)
        $gta5MinGpus = [
            HardwareModel::where('name', 'GTX 1050 Ti')->first()->id,
            HardwareModel::where('name', 'RX 570')->first()->id,
        ];
        $gta5Min->addGpus($gta5MinGpus);

        // GTA 5 Önerilen Sistem Gereksinimleri
        $gta5Rec = GameRequirement::create([
            'game_id' => $gta5->id,
            'type' => 'recommended',
            'ram' => 8,
            'disk' => 72,
        ]);

        // Önerilen CPU seçenekleri (orta seviye CPU'lar)
        $gta5RecCpus = [
            HardwareModel::where('name', 'Core i5-10400F')->first()->id,
            HardwareModel::where('name', 'Ryzen 5 3600')->first()->id,
        ];
        $gta5Rec->addCpus($gta5RecCpus);

        // Önerilen GPU seçenekleri (orta seviye GPU'lar)
        $gta5RecGpus = [
            HardwareModel::where('name', 'GTX 1060 6GB')->first()->id,
            HardwareModel::where('name', 'RX 580')->first()->id,
        ];
        $gta5Rec->addGpus($gta5RecGpus);

        echo "✅ GTA 5 başarıyla eklendi!\n";
        echo "🎮 Oyun: " . $gta5->name . "\n";
        echo "📊 Puan: " . $gta5->score . "\n";
        echo "💾 Minimum RAM: " . $gta5Min->ram . " GB\n";
        echo "💿 Disk Alanı: " . $gta5Min->disk . " GB\n";
        echo "💻 Minimum CPU Seçenekleri: " . count($gta5MinCpus) . " adet\n";
        echo "🎯 Minimum GPU Seçenekleri: " . count($gta5MinGpus) . " adet\n";
        echo "🚀 Önerilen CPU Seçenekleri: " . count($gta5RecCpus) . " adet\n";
        echo "⚡ Önerilen GPU Seçenekleri: " . count($gta5RecGpus) . " adet\n";
    }
}

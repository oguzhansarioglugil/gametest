<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\GameRequirement;
use App\Models\HardwareModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cyberpunk 2077
        $cyberpunk = Game::create([
            'name' => 'Cyberpunk 2077',
            'description' => 'Cyberpunk 2077, açık dünya aksiyon-macera hikayesi olan bir rol yapma oyunudur. Geleceğin megalopolisi Night City\'de geçen oyunda, güç, lüks ve vücut modifikasyonuna takıntılı bir dünyada yaşarsınız.',
            'image' => 'cyberpunk2077.jpg',
            'score' => 8.5,
        ]);

        // Minimum gereksinimler
        $cyberpunkMin = GameRequirement::create([
            'game_id' => $cyberpunk->id,
            'type' => 'minimum',
            'ram' => 8,
            'disk' => 70,
        ]);

        // Minimum CPU'lar (Intel ve AMD seçenekleri)
        $minCpus = [
            HardwareModel::where('name', 'Ryzen 3 3100')->first()->id,
            HardwareModel::where('name', 'Core i3-10100F')->first()->id,
        ];
        $cyberpunkMin->addCpus($minCpus);

        // Minimum GPU'lar (Nvidia ve AMD seçenekleri)
        $minGpus = [
            HardwareModel::where('name', 'GTX 1060 6GB')->first()->id,
            HardwareModel::where('name', 'RX 580')->first()->id,
        ];
        $cyberpunkMin->addGpus($minGpus);

        // Önerilen gereksinimler
        $cyberpunkRec = GameRequirement::create([
            'game_id' => $cyberpunk->id,
            'type' => 'recommended',
            'ram' => 16,
            'disk' => 70,
        ]);

        // Önerilen CPU'lar
        $recCpus = [
            HardwareModel::where('name', 'Ryzen 5 3600')->first()->id,
            HardwareModel::where('name', 'Core i5-10400F')->first()->id,
        ];
        $cyberpunkRec->addCpus($recCpus);

        // Önerilen GPU'lar
        $recGpus = [
            HardwareModel::where('name', 'RTX 2060')->first()->id,
            HardwareModel::where('name', 'RX 6600')->first()->id,
        ];
        $cyberpunkRec->addGpus($recGpus);

        // Red Dead Redemption 2
        $rdr2 = Game::create([
            'name' => 'Red Dead Redemption 2',
            'description' => 'Amerika\'nın kalbi olan yerde, Arthur Morgan ve Van der Linde çetesi kaçak olarak yaşamaya çalışır. İç çekişmeler ve hükümet güçleriyle mücadele ederken, çete dağılma tehlikesiyle karşı karşıyadır.',
            'image' => 'rdr2.jpg',
            'score' => 9.2,
        ]);

        // RDR2 Minimum gereksinimler
        $rdr2Min = GameRequirement::create([
            'game_id' => $rdr2->id,
            'type' => 'minimum',
            'ram' => 8,
            'disk' => 150,
        ]);

        $rdr2MinCpus = [
            HardwareModel::where('name', 'Core i5-10400F')->first()->id,
            HardwareModel::where('name', 'Ryzen 3 3100')->first()->id,
        ];
        $rdr2Min->addCpus($rdr2MinCpus);

        $rdr2MinGpus = [
            HardwareModel::where('name', 'GTX 1050 Ti')->first()->id,
            HardwareModel::where('name', 'RX 570')->first()->id,
        ];
        $rdr2Min->addGpus($rdr2MinGpus);

        // RDR2 Önerilen gereksinimler
        $rdr2Rec = GameRequirement::create([
            'game_id' => $rdr2->id,
            'type' => 'recommended',
            'ram' => 12,
            'disk' => 150,
        ]);

        $rdr2RecCpus = [
            HardwareModel::where('name', 'Core i7-10700F')->first()->id,
            HardwareModel::where('name', 'Ryzen 5 3600')->first()->id,
        ];
        $rdr2Rec->addCpus($rdr2RecCpus);

        $rdr2RecGpus = [
            HardwareModel::where('name', 'GTX 1060 6GB')->first()->id,
            HardwareModel::where('name', 'RX 580')->first()->id,
        ];
        $rdr2Rec->addGpus($rdr2RecGpus);

        // Elden Ring
        $eldenRing = Game::create([
            'name' => 'Elden Ring',
            'description' => 'FromSoftware\'in geliştirdiği ve George R.R. Martin\'in katkıda bulunduğu fantastik aksiyon RPG oyunu. Geniş açık dünyada keşif yapın ve zorlu düşmanlarla savaşın.',
            'image' => 'eldenring.jpg',
            'score' => 9.5,
        ]);

        // Elden Ring Minimum gereksinimler
        $eldenMin = GameRequirement::create([
            'game_id' => $eldenRing->id,
            'type' => 'minimum',
            'ram' => 12,
            'disk' => 60,
        ]);

        $eldenMinCpus = [
            HardwareModel::where('name', 'Core i5-10400F')->first()->id,
            HardwareModel::where('name', 'Ryzen 5 3600')->first()->id,
        ];
        $eldenMin->addCpus($eldenMinCpus);

        $eldenMinGpus = [
            HardwareModel::where('name', 'GTX 1060 6GB')->first()->id,
            HardwareModel::where('name', 'RX 580')->first()->id,
        ];
        $eldenMin->addGpus($eldenMinGpus);

        // Elden Ring Önerilen gereksinimler
        $eldenRec = GameRequirement::create([
            'game_id' => $eldenRing->id,
            'type' => 'recommended',
            'ram' => 16,
            'disk' => 60,
        ]);

        $eldenRecCpus = [
            HardwareModel::where('name', 'Core i7-11700F')->first()->id,
            HardwareModel::where('name', 'Ryzen 7 3700X')->first()->id,
        ];
        $eldenRec->addCpus($eldenRecCpus);

        $eldenRecGpus = [
            HardwareModel::where('name', 'RTX 2060')->first()->id,
            HardwareModel::where('name', 'RX 6600')->first()->id,
        ];
        $eldenRec->addGpus($eldenRecGpus);
    }
}

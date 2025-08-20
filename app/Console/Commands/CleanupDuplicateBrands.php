<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HardwareBrand;

class CleanupDuplicateBrands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hardware:cleanup-brands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Duplicate markaları temizle ve birleştir';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Duplicate markaları tespit ediliyor...');

        // Aynı isimde markaları grup halinde getir
        $duplicates = HardwareBrand::selectRaw('name, COUNT(*) as count')
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->info('✅ Duplicate marka bulunamadı!');
            return 0;
        }

        $this->warn('⚠️  Bulunan duplicate markalar:');
        foreach($duplicates as $duplicate) {
            $this->line("   - {$duplicate->name}: {$duplicate->count} adet");
        }

        if (!$this->confirm('🔧 Duplicate temizleme işlemine devam edilsin mi?')) {
            $this->info('İşlem iptal edildi.');
            return 0;
        }

        $totalCleaned = 0;

        foreach($duplicates as $duplicate) {
            $this->info("📋 {$duplicate->name} markası işleniyor...");

            // Aynı isimde olan markaları getir
            $brands = HardwareBrand::where('name', $duplicate->name)->orderBy('id')->get();

            // İlkini sakla, diğerlerini sil
            $firstBrand = $brands->first();
            $brandsToDelete = $brands->skip(1);

            $this->line("   ✅ Ana marka: ID {$firstBrand->id} - {$firstBrand->name}");

            foreach($brandsToDelete as $brandToDelete) {
                // Bu markaya ait modelleri ilk markaya taşı
                $modelCount = $brandToDelete->models()->count();

                if ($modelCount > 0) {
                    $brandToDelete->models()->update(['brand_id' => $firstBrand->id]);
                    $this->line("   📦 {$modelCount} model taşındı (ID {$brandToDelete->id} -> ID {$firstBrand->id})");
                }

                // Markayı sil
                $brandToDelete->delete();
                $this->line("   🗑️  Duplicate marka silindi: ID {$brandToDelete->id}");
                $totalCleaned++;
            }

            $this->info("   ✅ {$duplicate->name} markası temizlendi!");
        }

        $this->info("🎉 Tüm duplicate markalar başarıyla temizlendi!");
        $this->info("📊 Temizlenen duplicate sayısı: {$totalCleaned}");
        $this->info("📊 Şu anki marka sayısı: " . HardwareBrand::count());

        return 0;
    }
}

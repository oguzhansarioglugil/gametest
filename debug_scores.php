<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== DEBUG: CPU BENCHMARK SCORES ===\n\n";

// Kullanıcının sistemindeki CPU
$userCpus = ['Core i5-14600KF'];

// Oyun gereksinimlerindeki CPU'lar
$gameCpus = ['Core i7-12700F', 'Core i9-11900F'];

$allCpus = array_merge($userCpus, $gameCpus);

foreach ($allCpus as $cpuName) {
    $cpu = DB::table('hardware_models')
        ->join('hardware_brands', 'hardware_models.brand_id', '=', 'hardware_brands.id')
        ->where('hardware_models.name', $cpuName)
        ->where('hardware_models.type', 'cpu')
        ->select('hardware_models.*', 'hardware_brands.name as brand_name')
        ->first();

    if ($cpu) {
        echo "✓ {$cpu->brand_name} {$cpu->name}\n";
        echo "  - ID: {$cpu->id}\n";
        echo "  - Benchmark Score: " . ($cpu->benchmark_score ?? 'NULL') . "\n";
        echo "  - Created: {$cpu->created_at}\n\n";
    } else {
        echo "✗ CPU bulunamadı: $cpuName\n\n";
    }
}

echo "=== COMPARISON TEST ===\n";
$i5_14600kf = 28500;  // Kullanıcının CPU'su
$i7_12700f = 30200;   // Minimum gereksinim
$i9_11900f = 26800;   // Önerilen gereksinim

echo "User CPU (i5-14600KF): $i5_14600kf\n";
echo "Min Req (i7-12700F): $i7_12700f\n";
echo "Rec Req (i9-11900F): $i9_11900f\n\n";

echo "Logic check:\n";
echo "i5-14600KF >= i7-12700F? " . ($i5_14600kf >= $i7_12700f ? "YES (should be compatible)" : "NO (not compatible)") . "\n";
echo "i5-14600KF >= i9-11900F? " . ($i5_14600kf >= $i9_11900f ? "YES (should be compatible)" : "NO (not compatible)") . "\n";

echo "\n=== FIXING SCORES ===\n";
// i7-12700F puanını kontrol et ve düzelt
$i7Updated = DB::table('hardware_models')
    ->where('name', 'Core i7-12700F')
    ->where('type', 'cpu')
    ->update(['benchmark_score' => 30200]);

echo "i7-12700F score updated: " . ($i7Updated ? "SUCCESS" : "FAILED") . "\n";

// i9-11900F puanını kontrol et ve düzelt
$i9Updated = DB::table('hardware_models')
    ->where('name', 'Core i9-11900F')
    ->where('type', 'cpu')
    ->update(['benchmark_score' => 26800]);

echo "i9-11900F score updated: " . ($i9Updated ? "SUCCESS" : "FAILED") . "\n";

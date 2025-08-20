<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\UserSystem;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function show($id)
    {
        $game = Game::with([
            'minimumRequirements.cpus.brand',
            'minimumRequirements.gpus.brand',
            'recommendedRequirements.cpus.brand',
            'recommendedRequirements.gpus.brand'
        ])->findOrFail($id);

        return view('game.show', compact('game'));
    }

    public function systemTest($id)
    {
        $game = Game::with([
            'minimumRequirements.cpus.brand',
            'minimumRequirements.gpus.brand',
            'recommendedRequirements.cpus.brand',
            'recommendedRequirements.gpus.brand'
        ])->findOrFail($id);

        $user = auth()->user();

        // Kullanıcının sistem bilgisi var mı kontrol et
        $userSystem = UserSystem::where('user_id', $user->id)
            ->with(['cpu.brand', 'gpu.brand'])
            ->first();

        if (!$userSystem) {
            // Sistem bilgisi yoksa profile sayfasına yönlendir
            return redirect()->route('profile.index', ['tab' => 'system'])
                ->with('info', 'Sisteminizi test etmek için önce sistem bilgilerinizi girmeniz gerekiyor.');
        }

        // Kullanıcının CPU ve GPU markalarını al
        $userCpuBrandId = $userSystem->cpu ? $userSystem->cpu->brand_id : null;
        $userGpuBrandId = $userSystem->gpu ? $userSystem->gpu->brand_id : null;

        // Oyun gereksinimlerini kullanıcının markasına göre filtrele
        if ($game->minimumRequirements) {
            if ($userCpuBrandId) {
                $game->minimumRequirements->cpus = $game->minimumRequirements->cpus->where('brand_id', $userCpuBrandId);
            }
            if ($userGpuBrandId) {
                $game->minimumRequirements->gpus = $game->minimumRequirements->gpus->where('brand_id', $userGpuBrandId);
            }
        }

        if ($game->recommendedRequirements) {
            if ($userCpuBrandId) {
                $game->recommendedRequirements->cpus = $game->recommendedRequirements->cpus->where('brand_id', $userCpuBrandId);
            }
            if ($userGpuBrandId) {
                $game->recommendedRequirements->gpus = $game->recommendedRequirements->gpus->where('brand_id', $userGpuBrandId);
            }
        }

        // Karşılaştırma hesapla
        $comparison = $this->compareSystemWithGame($userSystem, $game);

        return view('game.system-test', compact('game', 'userSystem', 'comparison'));
    }

    private function compareSystemWithGame($userSystem, $game)
    {
        $comparison = [
            'minimum' => [
                'ram' => $this->compareValues($userSystem->ram, $game->minimumRequirements->ram ?? 0),
                'disk' => $this->compareValues($userSystem->disk, $game->minimumRequirements->disk ?? 0),
                'cpu_compatible' => $this->isCpuCompatible($userSystem->cpu, $game->minimumRequirements),
                'gpu_compatible' => $this->isGpuCompatible($userSystem->gpu, $game->minimumRequirements),
            ],
            'recommended' => null
        ];

        // Önerilen gereksinimler varsa karşılaştır
        if ($game->recommendedRequirements) {
            $comparison['recommended'] = [
                'ram' => $this->compareValues($userSystem->ram, $game->recommendedRequirements->ram ?? 0),
                'disk' => $this->compareValues($userSystem->disk, $game->recommendedRequirements->disk ?? 0),
                'cpu_compatible' => $this->isCpuCompatible($userSystem->cpu, $game->recommendedRequirements),
                'gpu_compatible' => $this->isGpuCompatible($userSystem->gpu, $game->recommendedRequirements),
            ];
        }

        return $comparison;
    }

    private function compareValues($userValue, $requiredValue)
    {
        if ($userValue >= $requiredValue) {
            return 'sufficient'; // Yeşil
        } else {
            return 'insufficient'; // Kırmızı
        }
    }

    private function isCpuCompatible($userCpu, $gameRequirement)
    {
        if (!$userCpu || !$gameRequirement) {
            return 'unknown';
        }

        // Kullanıcının CPU performans puanını al
        $userCpuScore = $this->getCpuPerformanceScore($userCpu);

        // Gereksinimler arasındaki en düşük CPU performans puanını bul
        $compatibleCpus = $gameRequirement->cpus;
        $minRequiredScore = 999999;

        foreach ($compatibleCpus as $cpu) {
            $cpuScore = $this->getCpuPerformanceScore($cpu);
            if ($cpuScore < $minRequiredScore) {
                $minRequiredScore = $cpuScore;
            }
        }

        // Kullanıcının CPU'su gerekli minimum puandan yüksek mi?
        if ($userCpuScore >= $minRequiredScore) {
            return 'sufficient';
        }

        return 'insufficient';
    }

    private function isGpuCompatible($userGpu, $gameRequirement)
    {
        if (!$userGpu || !$gameRequirement) {
            return 'unknown';
        }

        // Kullanıcının GPU performans puanını al
        $userGpuScore = $this->getGpuPerformanceScore($userGpu);

        // Gereksinimler arasındaki en düşük GPU performans puanını bul
        $compatibleGpus = $gameRequirement->gpus;
        $minRequiredScore = 999999;

        foreach ($compatibleGpus as $gpu) {
            $gpuScore = $this->getGpuPerformanceScore($gpu);
            if ($gpuScore < $minRequiredScore) {
                $minRequiredScore = $gpuScore;
            }
        }

        // Kullanıcının GPU'su gerekli minimum puandan yüksek mi?
        if ($userGpuScore >= $minRequiredScore) {
            return 'sufficient';
        }

        return 'insufficient';
    }

    private function getCpuPerformanceScore($cpu)
    {
        // Veritabanından benchmark puanını al
        if ($cpu->benchmark_score && $cpu->benchmark_score > 0) {
            return $cpu->benchmark_score;
        }

        // Eğer veritabanında puan yoksa varsayılan dön
        return 10000; // Varsayılan puan
    }

    private function getGpuPerformanceScore($gpu)
    {
        // Veritabanından benchmark puanını al
        if ($gpu->benchmark_score && $gpu->benchmark_score > 0) {
            return $gpu->benchmark_score;
        }

        // Eğer veritabanında puan yoksa varsayılan dön
        return 5000; // Varsayılan puan
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:1',
    ];

    /**
     * Oyunun sistem gereksinimleri
     */
    public function requirements()
    {
        return $this->hasMany(GameRequirement::class);
    }

    /**
     * Minimum sistem gereksinimleri
     */
    public function minimumRequirements()
    {
        return $this->hasOne(GameRequirement::class)->where('type', 'minimum');
    }

    /**
     * Önerilen sistem gereksinimleri
     */
    public function recommendedRequirements()
    {
        return $this->hasOne(GameRequirement::class)->where('type', 'recommended');
    }

    /**
     * Kullanıcının sistemi ile karşılaştırma
     */
    public function canRunOnSystem(UserSystem $userSystem)
    {
        $minReq = $this->minimumRequirements()->with(['cpus', 'gpus'])->first();

        if (!$minReq) {
            return null; // Sistem gereksinimleri belirtilmemiş
        }

        // CPU kontrolü - kullanıcının CPU'su minimum gereksinimler arasında var mı?
        $cpuCompatible = $minReq->cpus->contains('id', $userSystem->cpu_id);

        // GPU kontrolü - kullanıcının GPU'su minimum gereksinimler arasında var mı?
        $gpuCompatible = $minReq->gpus->contains('id', $userSystem->gpu_id);

        // RAM ve disk kontrolü
        $ramSufficient = $userSystem->ram >= $minReq->ram;
        $diskSufficient = $userSystem->disk >= $minReq->disk;

        return [
            'can_run' => $cpuCompatible && $gpuCompatible && $ramSufficient && $diskSufficient,
            'cpu_compatible' => $cpuCompatible,
            'gpu_compatible' => $gpuCompatible,
            'ram_sufficient' => $ramSufficient,
            'disk_sufficient' => $diskSufficient,
            'compatible_cpus' => $minReq->cpus,
            'compatible_gpus' => $minReq->gpus,
        ];
    }

    /**
     * Oyunun tüm uyumlu CPU'larını al (minimum + önerilen)
     */
    public function getAllCompatibleCpus()
    {
        $cpuIds = collect();

        foreach ($this->requirements as $requirement) {
            $cpuIds = $cpuIds->merge($requirement->cpus->pluck('id'));
        }

        return HardwareModel::whereIn('id', $cpuIds->unique())->with('brand')->get();
    }

    /**
     * Oyunun tüm uyumlu GPU'larını al (minimum + önerilen)
     */
    public function getAllCompatibleGpus()
    {
        $gpuIds = collect();

        foreach ($this->requirements as $requirement) {
            $gpuIds = $gpuIds->merge($requirement->gpus->pluck('id'));
        }

        return HardwareModel::whereIn('id', $gpuIds->unique())->with('brand')->get();
    }
}

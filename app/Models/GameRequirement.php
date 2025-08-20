<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'type',
        'ram',
        'disk',
    ];

    /**
     * Bu gereksinimlerin ait olduğu oyun
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Bu gereksinimin CPU'ları
     */
    public function cpus()
    {
        return $this->belongsToMany(HardwareModel::class, 'game_requirements_cpus', 'game_requirement_id', 'cpu_id')
            ->where('hardware_models.type', 'cpu')
            ->withTimestamps();
    }

    /**
     * Bu gereksinimin GPU'ları
     */
    public function gpus()
    {
        return $this->belongsToMany(HardwareModel::class, 'game_requirements_gpus', 'game_requirement_id', 'gpu_id')
            ->where('hardware_models.type', 'gpu')
            ->withTimestamps();
    }

    /**
     * CPU pivot kayıtları
     */
    public function cpuPivots()
    {
        return $this->hasMany(GameRequirementCpu::class);
    }

    /**
     * GPU pivot kayıtları
     */
    public function gpuPivots()
    {
        return $this->hasMany(GameRequirementGpu::class);
    }

    /**
     * Minimum gereksinimler
     */
    public static function minimum()
    {
        return self::where('type', 'minimum');
    }

    /**
     * Önerilen gereksinimler
     */
    public static function recommended()
    {
        return self::where('type', 'recommended');
    }

    /**
     * CPU'ları ekle
     */
    public function addCpus(array $cpuIds)
    {
        foreach ($cpuIds as $cpuId) {
            GameRequirementCpu::firstOrCreate([
                'game_requirement_id' => $this->id,
                'cpu_id' => $cpuId,
            ]);
        }
    }

    /**
     * GPU'ları ekle
     */
    public function addGpus(array $gpuIds)
    {
        foreach ($gpuIds as $gpuId) {
            GameRequirementGpu::firstOrCreate([
                'game_requirement_id' => $this->id,
                'gpu_id' => $gpuId,
            ]);
        }
    }
}

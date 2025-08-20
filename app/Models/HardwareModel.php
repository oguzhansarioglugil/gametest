<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'type',
        'description',
    ];

    /**
     * Bu modelin markası
     */
    public function brand()
    {
        return $this->belongsTo(HardwareBrand::class);
    }

    /**
     * Bu model CPU olarak kullanıldığı kullanıcı sistemleri
     */
    public function userSystemsCpu()
    {
        return $this->hasMany(UserSystem::class, 'cpu_id');
    }

    /**
     * Bu model GPU olarak kullanıldığı kullanıcı sistemleri
     */
    public function userSystemsGpu()
    {
        return $this->hasMany(UserSystem::class, 'gpu_id');
    }

    /**
     * Bu model CPU olarak kullanıldığı oyun gereksinimleri (pivot tablo üzerinden)
     */
    public function gameRequirementsCpu()
    {
        return $this->belongsToMany(GameRequirement::class, 'game_requirements_cpus', 'cpu_id', 'game_requirement_id');
    }

    /**
     * Bu model GPU olarak kullanıldığı oyun gereksinimleri (pivot tablo üzerinden)
     */
    public function gameRequirementsGpu()
    {
        return $this->belongsToMany(GameRequirement::class, 'game_requirements_gpus', 'gpu_id', 'game_requirement_id');
    }

    /**
     * CPU modelleri
     */
    public static function cpuModels()
    {
        return self::where('type', 'cpu')->with('brand')->get();
    }

    /**
     * GPU modelleri
     */
    public static function gpuModels()
    {
        return self::where('type', 'gpu')->with('brand')->get();
    }

    /**
     * Belirli bir markaya ait CPU modelleri
     */
    public static function cpuModelsByBrand($brandId)
    {
        return self::where('type', 'cpu')->where('brand_id', $brandId)->get();
    }

    /**
     * Belirli bir markaya ait GPU modelleri
     */
    public static function gpuModelsByBrand($brandId)
    {
        return self::where('type', 'gpu')->where('brand_id', $brandId)->get();
    }

    /**
     * Bu modelin toplam kullanım sayısı
     */
    public function getTotalUsageAttribute()
    {
        $userSystemsCount = 0;
        $gameRequirementsCount = 0;

        if ($this->type === 'cpu') {
            $userSystemsCount = $this->userSystemsCpu()->count();
            $gameRequirementsCount = $this->gameRequirementsCpu()->count();
        } else {
            $userSystemsCount = $this->userSystemsGpu()->count();
            $gameRequirementsCount = $this->gameRequirementsGpu()->count();
        }

        return $userSystemsCount + $gameRequirementsCount;
    }

    /**
     * Bu modelin kullanımda olup olmadığını kontrol et
     */
    public function isInUse()
    {
        return $this->total_usage > 0;
    }
}

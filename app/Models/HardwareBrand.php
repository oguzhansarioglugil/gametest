<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * Bu markaya ait modeller
     */
    public function models()
    {
        return $this->hasMany(HardwareModel::class, 'brand_id');
    }

    /**
     * CPU markaları
     */
    public static function cpuBrands()
    {
        return self::where('type', 'cpu')->get();
    }

    /**
     * GPU markaları
     */
    public static function gpuBrands()
    {
        return self::where('type', 'gpu')->get();
    }
}

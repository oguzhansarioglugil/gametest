<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRequirementGpu extends Model
{
    use HasFactory;

    protected $table = 'game_requirements_gpus';

    protected $fillable = [
        'game_requirement_id',
        'gpu_id',
    ];

    /**
     * Bu kaydın ait olduğu oyun gereksinimi
     */
    public function gameRequirement()
    {
        return $this->belongsTo(GameRequirement::class);
    }

    /**
     * Bu kaydın GPU modeli
     */
    public function gpu()
    {
        return $this->belongsTo(HardwareModel::class, 'gpu_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRequirementCpu extends Model
{
    use HasFactory;

    protected $table = 'game_requirements_cpus';

    protected $fillable = [
        'game_requirement_id',
        'cpu_id',
    ];

    /**
     * Bu kaydın ait olduğu oyun gereksinimi
     */
    public function gameRequirement()
    {
        return $this->belongsTo(GameRequirement::class);
    }

    /**
     * Bu kaydın CPU modeli
     */
    public function cpu()
    {
        return $this->belongsTo(HardwareModel::class, 'cpu_id');
    }
}

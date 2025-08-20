<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'cpu_id',
        'gpu_id',
        'ram',
        'disk',
    ];

    /**
     * Bu sistemin sahibi kullanıcı
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sistemin CPU'su
     */
    public function cpu()
    {
        return $this->belongsTo(HardwareModel::class, 'cpu_id');
    }

    /**
     * Sistemin GPU'su
     */
    public function gpu()
    {
        return $this->belongsTo(HardwareModel::class, 'gpu_id');
    }

    /**
     * Sistemin belirli bir oyunu çalıştırıp çalıştıramayacağını kontrol et
     */
    public function canRunGame(Game $game)
    {
        return $game->canRunOnSystem($this);
    }

    /**
     * Sistem özetini al
     */
    public function getSummaryAttribute()
    {
        return [
            'name' => $this->name,
            'cpu' => $this->cpu ? $this->cpu->brand->name . ' ' . $this->cpu->name : 'Belirtilmemiş',
            'gpu' => $this->gpu ? $this->gpu->brand->name . ' ' . $this->gpu->name : 'Belirtilmemiş',
            'ram' => $this->ram . ' GB',
            'disk' => $this->disk . ' GB',
        ];
    }
}

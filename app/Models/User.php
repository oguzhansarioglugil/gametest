<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'birth_date',
        'role',
        'rank',
        'experience_points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date:Y-m-d',
        ];
    }

    /**
     * Kullanıcının sistemleri
     */
    public function systems()
    {
        return $this->hasMany(UserSystem::class);
    }

    /**
     * Kullanıcının ilk/ana sistemi (sistem testi için)
     */
    public function userSystem()
    {
        return $this->hasOne(UserSystem::class)->latest();
    }

    /**
     * Kullanıcının admin olup olmadığını kontrol et
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    /**
     * Kullanıcının super admin olup olmadığını kontrol et
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    /**
     * Kullanıcının normal kullanıcı olup olmadığını kontrol et
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Role display name
     */
    public function getRoleDisplayName()
    {
        return match($this->role) {
            'user' => 'Kullanıcı',
            'admin' => 'Yönetici',
            'super_admin' => 'Süper Yönetici',
            default => 'Bilinmeyen'
        };
    }

    /**
     * Role badge HTML with colors and effects
     */
    public function getRoleBadgeHtml()
    {
        return match($this->role) {
            'user' => '<span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Kullanıcı</span>',
            'admin' => '<span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full animate-pulse">🔧 Yönetici</span>',
            'super_admin' => '<span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full super-admin-badge">❄️ Süper Yönetici</span>',
            default => '<span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Bilinmeyen</span>'
        };
    }

    /**
     * Rank seviyesi tanımları
     */
    public static function getRankLevels()
    {
        return [
            'Çaylak' => ['min_exp' => 0, 'icon' => '🌱', 'color' => 'gray'],
            'Oyuncu' => ['min_exp' => 100, 'icon' => '🎮', 'color' => 'blue'],
            'Gamer' => ['min_exp' => 300, 'icon' => '🕹️', 'color' => 'green'],
            'Pro Gamer' => ['min_exp' => 600, 'icon' => '⚡', 'color' => 'yellow'],
            'Elite' => ['min_exp' => 1000, 'icon' => '👑', 'color' => 'purple'],
            'Legend' => ['min_exp' => 1500, 'icon' => '🏆', 'color' => 'orange'],
            'Master' => ['min_exp' => 2500, 'icon' => '💎', 'color' => 'indigo'],
            'Grandmaster' => ['min_exp' => 4000, 'icon' => '🔥', 'color' => 'red'],
            'Immortal' => ['min_exp' => 6000, 'icon' => '✨', 'color' => 'pink'],
            'Gaming God' => ['min_exp' => 10000, 'icon' => '🌟', 'color' => 'gradient']
        ];
    }

    /**
     * Kullanıcının rank'ini deneyim puanına göre güncelle
     */
    public function updateRank()
    {
        $levels = self::getRankLevels();
        $currentRank = 'Çaylak';

        foreach ($levels as $rank => $data) {
            if ($this->experience_points >= $data['min_exp']) {
                $currentRank = $rank;
            }
        }

        if ($this->rank !== $currentRank) {
            $oldRank = $this->rank;
            $this->rank = $currentRank;
            $this->save();

            // Rank up event (isterseniz notification ekleyebiliriz)
            return [
                'rank_up' => true,
                'old_rank' => $oldRank,
                'new_rank' => $currentRank
            ];
        }

        return ['rank_up' => false];
    }

    /**
     * Deneyim puanı ekle
     */
    public function addExperience(int $points)
    {
        $this->experience_points += $points;
        $this->save();

        return $this->updateRank();
    }

    /**
     * Rank badge HTML
     */
    public function getRankBadgeHtml()
    {
        $levels = self::getRankLevels();
        $rankData = $levels[$this->rank] ?? $levels['Çaylak'];

        $colorClasses = match($rankData['color']) {
            'gray' => 'bg-gray-100 text-gray-800',
            'blue' => 'bg-blue-100 text-blue-800',
            'green' => 'bg-green-100 text-green-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'purple' => 'bg-purple-100 text-purple-800',
            'orange' => 'bg-orange-100 text-orange-800',
            'indigo' => 'bg-indigo-100 text-indigo-800',
            'red' => 'bg-red-100 text-red-800',
            'pink' => 'bg-pink-100 text-pink-800',
            'gradient' => 'bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500 text-white',
            default => 'bg-gray-100 text-gray-800'
        };

        return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $colorClasses . '">' .
               $rankData['icon'] . ' ' . $this->rank . '</span>';
    }

    /**
     * Sonraki rank için gereken deneyim puanı
     */
    public function getNextRankExperience()
    {
        $levels = self::getRankLevels();
        $currentRankData = $levels[$this->rank] ?? $levels['Çaylak'];

        foreach ($levels as $rank => $data) {
            if ($data['min_exp'] > $currentRankData['min_exp']) {
                return [
                    'next_rank' => $rank,
                    'required_exp' => $data['min_exp'],
                    'current_exp' => $this->experience_points,
                    'needed_exp' => $data['min_exp'] - $this->experience_points
                ];
            }
        }

        return null; // Max rank'e ulaşmış
    }

    /**
     * Rank progress percentage
     */
    public function getRankProgress()
    {
        $next = $this->getNextRankExperience();

        if (!$next) {
            return 100; // Max rank
        }

        $levels = self::getRankLevels();
        $currentRankData = $levels[$this->rank] ?? $levels['Çaylak'];

        $currentMin = $currentRankData['min_exp'];
        $nextMin = $next['required_exp'];
        $current = $this->experience_points;

        $progress = (($current - $currentMin) / ($nextMin - $currentMin)) * 100;

        return min(100, max(0, $progress));
    }
}

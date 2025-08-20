<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use App\Models\HardwareModel;
use App\Models\GameRequirement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_games' => Game::count(),
            'total_users' => User::count(),
            'total_admins' => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'hardware_models' => HardwareModel::count(),
            'cpus' => HardwareModel::where('type', 'cpu')->count(),
            'gpus' => HardwareModel::where('type', 'gpu')->count(),
        ];

        // Son eklenen oyunlar
        $recentGames = Game::latest()->take(5)->get();

        // Son kayıt olan kullanıcılar
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentGames', 'recentUsers'));
    }

    /**
     * Kullanıcı listesi (Sadece SuperAdmin)
     */
    public function users()
    {
        $users = User::with('systems')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Kullanıcı detayı (Sadece SuperAdmin)
     */
    public function showUser(User $user)
    {
        $user->load('systems');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Kullanıcı rolünü güncelle (Sadece SuperAdmin)
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,super_admin'
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        return back()->with('success', "Kullanıcının rolü {$oldRole} → {$request->role} olarak güncellendi.");
    }

    /**
     * Kullanıcı rank'ini güncelle (Sadece SuperAdmin)
     */
    public function updateUserRank(Request $request, User $user)
    {
        $validRanks = array_keys(User::getRankLevels());

        $request->validate([
            'rank' => 'required|in:' . implode(',', $validRanks),
            'experience_points' => 'nullable|integer|min:0|max:50000'
        ]);

        $oldRank = $user->rank;
        $oldExp = $user->experience_points;

        // Experience points değiştirilmişse önce onu güncelle
        if ($request->has('experience_points') && $request->experience_points !== null) {
            $user->experience_points = $request->experience_points;
        }

        // Rank'i güncelle
        $user->rank = $request->rank;
        $user->save();

        $message = "Kullanıcının rank'i {$oldRank} → {$request->rank} olarak güncellendi.";

        if ($request->has('experience_points') && $request->experience_points !== null) {
            $message .= " Deneyim puanı {$oldExp} → {$request->experience_points} olarak güncellendi.";
        }

        return back()->with('success', $message);
    }

    /**
     * Kullanıcı deneyim puanını güncelle (Sadece SuperAdmin)
     */
    public function updateUserExperience(Request $request, User $user)
    {
        $request->validate([
            'experience_points' => 'required|integer|min:0|max:50000'
        ]);

        $oldExp = $user->experience_points;
        $user->experience_points = $request->experience_points;
        $user->save();

        // Rank'i otomatik güncelle
        $rankResult = $user->updateRank();

        $message = "Deneyim puanı {$oldExp} → {$request->experience_points} olarak güncellendi.";

        if ($rankResult['rank_up']) {
            $message .= " Rank otomatik olarak {$rankResult['old_rank']} → {$rankResult['new_rank']} seviyesine yükseldi!";
        }

        return back()->with('success', $message);
    }

    /**
     * Kullanıcı durumunu değiştir (Sadece SuperAdmin)
     */
    public function toggleUserStatus(User $user)
    {
        // Bu özellik için users tablosuna 'status' alanı eklenebilir
        return back()->with('info', 'Kullanıcı durumu değiştirme özelliği yakında eklenecek.');
    }

    /**
     * Sistem ayarları (Sadece SuperAdmin)
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Sistem ayarlarını güncelle (Sadece SuperAdmin)
     */
    public function updateSettings(Request $request)
    {
        // Sistem ayarları güncelleme logic'i buraya gelecek
        return back()->with('success', 'Sistem ayarları güncellendi.');
    }

    /**
     * Admin listesi (Sadece SuperAdmin)
     */
    public function admins()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])->paginate(20);
        return view('admin.admins.index', compact('admins'));
    }
}

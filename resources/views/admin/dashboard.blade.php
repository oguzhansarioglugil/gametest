@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Sistem istatistikleri ve genel bakış')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Toplam Oyunlar -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-gamepad text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Oyunlar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_games']) }}</p>
                </div>
            </div>
        </div>

        <!-- Toplam Kullanıcılar -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Kullanıcılar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
        </div>

        <!-- Toplam Adminler -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Adminler</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_admins']) }}</p>
                </div>
            </div>
        </div>

        <!-- Toplam Donanım -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100">
                    <i class="fas fa-memory text-indigo-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Donanım</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['hardware_models']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Son Eklenen Oyunlar -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-gamepad mr-2 text-green-600"></i>
                    Son Eklenen Oyunlar
                </h3>
            </div>
            <div class="p-6">
                @if($recentGames->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentGames as $game)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-gamepad text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $game->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $game->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($game->score)
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                            ⭐ {{ $game->score }}
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.games.show', $game->id) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.games.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Tüm oyunları görüntüle →
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Henüz oyun eklenmemiş.</p>
                @endif
            </div>
        </div>

        <!-- Son Kayıt Olan Kullanıcılar -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-users mr-2 text-blue-600"></i>
                    Son Kayıt Olan Kullanıcılar
                </h3>
            </div>
            <div class="p-6">
                @if($recentUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }} {{ $user->surname }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                            {!! $user->getRankBadgeHtml() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    {!! $user->getRoleBadgeHtml() !!}
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ number_format($user->experience_points) }} XP
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Henüz kullanıcı yok.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <i class="fas fa-bolt mr-2 text-yellow-600"></i>
            Hızlı İşlemler
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.games.create') }}"
               class="flex items-center justify-center p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors group">
                <div class="text-center">
                    <i class="fas fa-plus text-green-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm font-medium text-green-800">Yeni Oyun Ekle</p>
                </div>
            </a>

            <a href="{{ route('admin.games.index') }}"
               class="flex items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors group">
                <div class="text-center">
                    <i class="fas fa-list text-blue-600 text-2xl mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm font-medium text-blue-800">Oyunları Listele</p>
                </div>
            </a>

            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg border border-gray-200 opacity-50">
                <div class="text-center">
                    <i class="fas fa-users text-gray-400 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-500">Kullanıcı Yönetimi</p>
                    <p class="text-xs text-gray-400">Yakında</p>
                </div>
            </div>

            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg border border-gray-200 opacity-50">
                <div class="text-center">
                    <i class="fas fa-microchip text-gray-400 text-2xl mb-2"></i>
                    <p class="text-sm font-medium text-gray-500">Donanım Yönetimi</p>
                    <p class="text-xs text-gray-400">Yakında</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Super Admin badge efekti */
.super-admin-badge {
    position: relative;
    background: linear-gradient(135deg, #fecaca, #f87171) !important;
    color: #7f1d1d !important;
    animation: shimmer 2s infinite;
    border: 1px solid #dc2626;
}

@keyframes shimmer {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Admin pulse efekti */
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: .8;
        transform: scale(1.02);
    }
}
</style>
@endpush

@extends('layouts.admin')

@section('title', 'Sistem Ayarları - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sistem Ayarları</h1>
            <p class="text-gray-600">Site genelindeki ayarları yönetin</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="fas fa-shield-alt mr-1"></i>
                Sadece SuperAdmin
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Ana Ayarlar -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Site Ayarları -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-globe mr-2 text-blue-600"></i>
                    Site Ayarları
                </h3>

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Site Adı</label>
                            <input type="text" name="site_name" value="GameTest"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Site Açıklaması</label>
                            <input type="text" name="site_description" value="Oyun Performans Test Platformu"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site URL</label>
                        <input type="url" name="site_url" value="{{ url('/') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Admin E-posta</label>
                        <input type="email" name="admin_email" value="admin@gametest.com"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="maintenance_mode" id="maintenance_mode"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                            Bakım Modu (Site geçici olarak kapatılır)
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Ayarları Kaydet
                        </button>
                    </div>
                </form>
            </div>

            <!-- Rank Sistemi Ayarları -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                    Rank Sistemi Ayarları
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Günlük Giriş XP</label>
                            <input type="number" name="daily_login_xp" value="5" min="0" max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Yorum XP</label>
                            <input type="number" name="comment_xp" value="10" min="0" max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profil Tamamlama XP</label>
                            <input type="number" name="profile_complete_xp" value="25" min="0" max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Oyun İnceleme XP</label>
                            <input type="number" name="game_review_xp" value="50" min="0" max="200"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="rank_system_enabled" id="rank_system_enabled" checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="rank_system_enabled" class="ml-2 block text-sm text-gray-900">
                            Rank sistemi aktif
                        </label>
                    </div>
                </div>
            </div>

            <!-- Güvenlik Ayarları -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-shield-alt mr-2 text-red-600"></i>
                    Güvenlik Ayarları
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="force_https" id="force_https" checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="force_https" class="ml-2 block text-sm text-gray-900">
                            HTTPS zorunlu
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="registration_enabled" id="registration_enabled" checked
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="registration_enabled" class="ml-2 block text-sm text-gray-900">
                            Yeni kayıtlar açık
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Şifre Uzunluğu</label>
                        <input type="number" name="min_password_length" value="6" min="4" max="20"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Sistem Bilgileri -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                    Sistem Bilgileri
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Laravel Versiyon</span>
                        <span class="font-medium">{{ app()->version() }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">PHP Versiyon</span>
                        <span class="font-medium">{{ PHP_VERSION }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Sunucu</span>
                        <span class="font-medium">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Bilinmeyen' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Veritabanı</span>
                        <span class="font-medium">MySQL</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Zaman Dilimi</span>
                        <span class="font-medium">{{ config('app.timezone') }}</span>
                    </div>
                </div>
            </div>

            <!-- Cache Yönetimi -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-memory mr-2 text-green-600"></i>
                    Cache Yönetimi
                </h3>

                <div class="space-y-3">
                    <button class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                        <i class="fas fa-sync mr-2"></i>
                        Cache Temizle
                    </button>

                    <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        <i class="fas fa-cog mr-2"></i>
                        Config Cache
                    </button>

                    <button class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm">
                        <i class="fas fa-route mr-2"></i>
                        Route Cache
                    </button>
                </div>
            </div>

            <!-- Hızlı İstatistikler -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-line mr-2 text-orange-600"></i>
                    Hızlı İstatistikler
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Disk Kullanımı</span>
                        <span class="font-medium text-orange-600">~{{ number_format(disk_free_space('/') / 1024 / 1024 / 1024, 1) }} GB</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Bellek Kullanımı</span>
                        <span class="font-medium text-blue-600">{{ number_format(memory_get_usage() / 1024 / 1024, 1) }} MB</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Çalışma Süresi</span>
                        <span class="font-medium text-green-600">{{ number_format(microtime(true) - LARAVEL_START, 3) }}s</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

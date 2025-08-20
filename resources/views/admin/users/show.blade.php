@extends('layouts.admin')

@section('title', $user->name . ' - Kullanıcı Detayı')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}"
               class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }} {{ $user->surname }}</h1>
                <p class="text-gray-600">Kullanıcı Detayları</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            {!! $user->getRoleBadgeHtml() !!}
            {!! $user->getRankBadgeHtml() !!}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kullanıcı Bilgileri -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Kişisel Bilgiler -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Kişisel Bilgiler
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }} {{ $user->surname }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kullanıcı Adı</label>
                        <p class="mt-1 text-sm text-gray-900">@{{ $user->username }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-posta</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Doğum Tarihi</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Belirtilmemiş' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kayıt Tarihi</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $user->created_at->format('d.m.Y H:i') }}
                            <span class="text-gray-500">({{ $user->created_at->diffForHumans() }})</span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Son Güncelleme</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $user->updated_at->format('d.m.Y H:i') }}
                            <span class="text-gray-500">({{ $user->updated_at->diffForHumans() }})</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sistem Bilgileri -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-desktop mr-2 text-green-600"></i>
                    Sistem Bilgileri
                </h3>

                @if($user->systems->count() > 0)
                    @foreach($user->systems as $system)
                        <div class="border rounded-lg p-4 {{ !$loop->last ? 'mb-4' : '' }}">
                            <h4 class="font-medium text-gray-900 mb-3">{{ $system->system_name }}</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">İşlemci (CPU)</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $system->cpu->brand->name ?? 'Bilinmeyen' }} {{ $system->cpu->name ?? 'Bilinmeyen' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ekran Kartı (GPU)</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $system->gpu->brand->name ?? 'Bilinmeyen' }} {{ $system->gpu->name ?? 'Bilinmeyen' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RAM</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $system->ram }} GB</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Disk Alanı</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $system->disk }} GB</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-desktop text-4xl mb-4"></i>
                        <p>Henüz sistem bilgisi eklenmemiş</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Rank & Experience -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                    Rütbe & Deneyim
                </h3>

                <div class="text-center mb-6">
                    @php
                        $rankLevels = App\Models\User::getRankLevels();
                        $currentRankData = $rankLevels[$user->rank] ?? $rankLevels['Çaylak'];
                    @endphp

                    <div class="text-4xl mb-2">{{ $currentRankData['icon'] }}</div>
                    <h4 class="text-xl font-bold text-gray-800">{{ $user->rank }}</h4>
                    <p class="text-gray-600 text-sm mb-4">Mevcut Rütbe</p>

                    <div class="bg-gray-100 rounded-lg p-3 mb-4">
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($user->experience_points) }}</div>
                        <div class="text-sm text-gray-600">Deneyim Puanı</div>
                    </div>

                    @php
                        $nextRank = $user->getNextRankExperience();
                        $rankProgress = $user->getRankProgress();
                    @endphp

                    @if($nextRank)
                        <div class="bg-gray-100 rounded-lg p-3">
                            <div class="text-sm font-semibold text-orange-600 mb-2">{{ $nextRank['next_rank'] }}</div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full"
                                     style="width: {{ $rankProgress }}%"></div>
                            </div>
                            <div class="text-xs text-gray-600">
                                {{ number_format($nextRank['needed_exp']) }} XP eksik
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500 rounded-lg p-3 text-white">
                            <div class="text-sm font-bold">🌟 Maximum Seviye!</div>
                        </div>
                    @endif
                </div>

                <!-- Rank Yönetimi -->
                <div class="border-t pt-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">
                        <i class="fas fa-cog mr-2"></i>
                        Rank Yönetimi
                    </h4>

                    <!-- Hızlı Deneyim Değiştirme -->
                    <form action="{{ route('admin.users.update-experience', $user) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="flex space-x-2">
                            <input type="number"
                                   name="experience_points"
                                   value="{{ $user->experience_points }}"
                                   min="0"
                                   max="50000"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit"
                                    class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-sync mr-1"></i>
                                XP Güncelle
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Rank otomatik olarak güncellenecek</p>
                    </form>

                    <!-- Manuel Rank Değiştirme -->
                    <form action="{{ route('admin.users.update-rank', $user) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Manuel Rank Seçimi</label>
                                <select name="rank"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @foreach($rankLevels as $rank => $data)
                                        <option value="{{ $rank }}" {{ $user->rank === $rank ? 'selected' : '' }}>
                                            {{ $data['icon'] }} {{ $rank }} ({{ number_format($data['min_exp']) }} XP)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Deneyim Puanı (İsteğe bağlı)</label>
                                <input type="number"
                                       name="experience_points"
                                       placeholder="Boş bırakırsan değişmez"
                                       min="0"
                                       max="50000"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <button type="submit"
                                    class="w-full px-3 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition-colors"
                                    onclick="return confirm('{{ $user->name }} kullanıcısının rank\'ini manuel olarak değiştirmek istediğinizden emin misiniz?')">
                                <i class="fas fa-crown mr-1"></i>
                                Rank\'i Manuel Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Management -->
            @if($user->id !== Auth::id())
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <i class="fas fa-user-cog mr-2 text-purple-600"></i>
                        Rol Yönetimi
                    </h3>

                    <div class="space-y-3">
                        @foreach(['user' => 'Kullanıcı', 'admin' => 'Admin', 'super_admin' => 'SuperAdmin'] as $role => $label)
                            @if($user->role !== $role)
                                <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="role" value="{{ $role }}">
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm border rounded-lg hover:bg-gray-50 transition-colors
                                                   {{ $role === 'super_admin' ? 'border-red-300 text-red-700' :
                                                      ($role === 'admin' ? 'border-orange-300 text-orange-700' : 'border-green-300 text-green-700') }}"
                                            onclick="return confirm('{{ $user->name }} kullanıcısının rolünü {{ $label }} yapmak istediğinizden emin misiniz?')">
                                        <i class="fas fa-{{ $role === 'super_admin' ? 'user-shield' : ($role === 'admin' ? 'user-cog' : 'user') }} mr-2"></i>
                                        {{ $label }} Yap
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-chart-bar mr-2 text-indigo-600"></i>
                    İstatistikler
                </h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Sistem Sayısı</span>
                        <span class="text-sm font-medium">{{ $user->systems->count() }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Hesap Yaşı</span>
                        <span class="text-sm font-medium">{{ $user->created_at->diffInDays() }} gün</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Son Aktivite</span>
                        <span class="text-sm font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Profilim - GameTest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Sayfa Başlığı -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full">
                    <i class="fas fa-user text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profilim</h1>
                    <p class="text-gray-600">Hesap bilgilerinizi ve sistem ayarlarınızı yönetin</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden" x-data="profileTabs()">
            <!-- Tab Headers -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button
                        @click="activeTab = 'profile'"
                        :class="activeTab === 'profile' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        <i class="fas fa-user mr-2"></i>
                        Kişisel Bilgilerim
                    </button>
                    <button
                        @click="activeTab = 'rank'"
                        :class="activeTab === 'rank' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        <i class="fas fa-trophy mr-2"></i>
                        Rütbem
                    </button>
                    <button
                        @click="activeTab = 'password'"
                        :class="activeTab === 'password' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        <i class="fas fa-lock mr-2"></i>
                        Şifremi Yenile
                    </button>
                    <button
                        @click="activeTab = 'system'"
                        :class="activeTab === 'system' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    >
                        <i class="fas fa-desktop mr-2"></i>
                        Sistemim
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Success ve Error Mesajları -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                            <div class="text-green-800 font-medium">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3 mt-0.5"></i>
                            <div>
                                <div class="text-red-800 font-medium mb-2">Bir hata oluştu:</div>
                                <ul class="text-red-700 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Kişisel Bilgilerim Tab -->
                <div x-show="activeTab === 'profile'" x-transition>
                    <div class="max-w-2xl">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Kişisel Bilgilerim</h3>
                        <p class="text-sm text-gray-600 mb-6">Hesap bilgilerinizi güncelleyebilirsiniz.</p>

                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Ad ve Soyad -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-blue-600"></i>
                                        Ad
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                                        placeholder="Adınız"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="surname" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-blue-600"></i>
                                        Soyad
                                    </label>
                                    <input
                                        type="text"
                                        id="surname"
                                        name="surname"
                                        value="{{ old('surname', $user->surname) }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('surname') border-red-500 @enderror"
                                        placeholder="Soyadınız"
                                    >
                                    @error('surname')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kullanıcı Adı -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-at mr-2 text-blue-600"></i>
                                    Kullanıcı Adı
                                </label>
                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    value="{{ old('username', $user->username) }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('username') border-red-500 @enderror"
                                    placeholder="kullaniciadi"
                                >
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- E-posta -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                    E-posta Adresi
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                                    placeholder="ornek@email.com"
                                >
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Doğum Tarihi -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                    Doğum Tarihi
                                </label>
                                @php
                                    $birthDateValue = old('birth_date', $user->birth_date);
                                    if ($birthDateValue && !is_string($birthDateValue)) {
                                        $birthDateValue = $birthDateValue->format('Y-m-d');
                                    }
                                @endphp
                                <input
                                    type="date"
                                    id="birth_date"
                                    name="birth_date"
                                    value="{{ $birthDateValue }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('birth_date') border-red-500 @enderror"
                                >

                                @error('birth_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kaydet Butonu -->
                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium"
                                >
                                    <i class="fas fa-save mr-2"></i>
                                    Bilgileri Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Rütbem Tab -->
                <div x-show="activeTab === 'rank'" x-transition>
                    <div class="max-w-4xl">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Rütbem ve Deneyim</h3>
                        <p class="text-sm text-gray-600 mb-6">Oyun deneyiminiz ve seviyeniz hakkında bilgiler.</p>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Mevcut Rank Bilgisi -->
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 border border-blue-200">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="text-6xl mb-2">
                                            @php
                                                $currentRankData = $rankLevels[$user->rank] ?? $rankLevels['Çaylak'];
                                            @endphp
                                            {{ $currentRankData['icon'] }}
                                        </div>
                                        <h4 class="text-2xl font-bold text-gray-800">{{ $user->rank }}</h4>
                                        <p class="text-gray-600 text-sm">Mevcut Rütbeniz</p>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="bg-white rounded-lg p-3">
                                            <div class="text-3xl font-bold text-blue-600">{{ number_format($user->experience_points) }}</div>
                                            <div class="text-sm text-gray-600">Deneyim Puanı</div>
                                        </div>

                                        @if($nextRank)
                                            <div class="bg-white rounded-lg p-3">
                                                <div class="text-lg font-semibold text-orange-600">{{ $nextRank['next_rank'] }}</div>
                                                <div class="text-sm text-gray-600 mb-2">Sonraki Rütbe</div>

                                                <!-- Progress Bar -->
                                                <div class="w-full bg-gray-200 rounded-full h-3">
                                                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-300"
                                                         style="width: {{ $rankProgress }}%"></div>
                                                </div>
                                                <div class="flex justify-between text-xs text-gray-600 mt-1">
                                                    <span>{{ number_format($user->experience_points) }} XP</span>
                                                    <span>{{ number_format($nextRank['required_exp']) }} XP</span>
                                                </div>
                                                <div class="text-center text-sm text-gray-700 mt-2">
                                                    <span class="font-medium">{{ number_format($nextRank['needed_exp']) }} XP</span> eksik
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-gradient-to-r from-yellow-400 via-red-500 to-pink-500 rounded-lg p-3 text-white">
                                                <div class="text-lg font-bold">🌟 Maximum Seviye!</div>
                                                <div class="text-sm opacity-90">En yüksek rütbeye ulaştınız!</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Rank Hiyerarşisi -->
                            <div class="bg-white rounded-xl border border-gray-200 p-6">
                                <h5 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                                    Rütbe Sistemi
                                </h5>

                                <div class="space-y-3 max-h-96 overflow-y-auto">
                                    @foreach($rankLevels as $rank => $data)
                                        <div class="flex items-center justify-between p-3 rounded-lg {{ $user->rank === $rank ? 'bg-blue-50 border-2 border-blue-300' : 'bg-gray-50 hover:bg-gray-100' }} transition-colors">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-2xl">{{ $data['icon'] }}</span>
                                                <div>
                                                    <div class="font-medium {{ $user->rank === $rank ? 'text-blue-800' : 'text-gray-800' }}">
                                                        {{ $rank }}
                                                        @if($user->rank === $rank)
                                                            <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full ml-2">Mevcut</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ number_format($data['min_exp']) }} XP gerekli
                                                    </div>
                                                </div>
                                            </div>

                                            @if($user->experience_points >= $data['min_exp'])
                                                <i class="fas fa-check-circle text-green-500"></i>
                                            @elseif($user->rank === $rank)
                                                <i class="fas fa-star text-blue-500"></i>
                                            @else
                                                <i class="fas fa-lock text-gray-400"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Deneyim Kazanma Yolları -->
                        <div class="mt-8 bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
                            <h5 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Deneyim Nasıl Kazanılır?
                            </h5>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="bg-white rounded-lg p-4 text-center">
                                    <i class="fas fa-gamepad text-blue-500 text-2xl mb-2"></i>
                                    <div class="font-medium text-gray-800">Oyun İnceleme</div>
                                    <div class="text-sm text-gray-600">+50 XP</div>
                                </div>

                                <div class="bg-white rounded-lg p-4 text-center">
                                    <i class="fas fa-comment text-green-500 text-2xl mb-2"></i>
                                    <div class="font-medium text-gray-800">Yorum Yapma</div>
                                    <div class="text-sm text-gray-600">+10 XP</div>
                                </div>

                                <div class="bg-white rounded-lg p-4 text-center">
                                    <i class="fas fa-user-plus text-purple-500 text-2xl mb-2"></i>
                                    <div class="font-medium text-gray-800">Profil Tamamlama</div>
                                    <div class="text-sm text-gray-600">+25 XP</div>
                                </div>

                                <div class="bg-white rounded-lg p-4 text-center">
                                    <i class="fas fa-calendar text-orange-500 text-2xl mb-2"></i>
                                    <div class="font-medium text-gray-800">Günlük Giriş</div>
                                    <div class="text-sm text-gray-600">+5 XP</div>
                                </div>
                            </div>
                        </div>

                        <!-- Test Butonu (Development Only) -->
                        <div class="mt-6 text-center">
                            <form action="{{ route('profile.add-experience') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-3 rounded-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 font-medium shadow-lg">
                                    <i class="fas fa-plus mr-2"></i>
                                    Test: +50 XP Ekle
                                </button>
                            </form>
                            <p class="text-xs text-gray-500 mt-2">Bu buton sadece test amaçlıdır</p>
                        </div>
                    </div>
                </div>

                <!-- Şifremi Yenile Tab -->
                <div x-show="activeTab === 'password'" x-transition>
                    <div class="max-w-2xl">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Şifre Değiştir</h3>
                        <p class="text-sm text-gray-600 mb-6">Güvenliğiniz için güçlü bir şifre seçin.</p>

                        <form action="{{ route('profile.password') }}" method="POST" class="space-y-6" x-data="passwordForm()">
                            @csrf

                            <!-- Mevcut Şifre -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-blue-600"></i>
                                    Mevcut Şifre
                                </label>
                                <div class="relative">
                                    <input
                                        type="password"
                                        id="current_password"
                                        name="current_password"
                                        required
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('current_password') border-red-500 @enderror"
                                        placeholder="Mevcut şifrenizi giriniz"
                                    >
                                </div>
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Yeni Şifre -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-key mr-2 text-blue-600"></i>
                                    Yeni Şifre
                                </label>
                                <div class="relative">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        x-model="password"
                                        @input="validatePassword()"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror"
                                        placeholder="En az 6 karakter"
                                    >
                                </div>
                                <!-- Şifre Güçlülük Göstergesi -->
                                <div class="mt-2" x-show="password.length > 0">
                                    <div class="flex space-x-1">
                                        <div class="h-2 flex-1 rounded" :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                                        <div class="h-2 flex-1 rounded" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                                        <div class="h-2 flex-1 rounded" :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
                                    </div>
                                    <p class="mt-1 text-xs" :class="passwordStrengthColor">
                                        <span x-text="passwordStrengthText"></span>
                                    </p>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Şifre Tekrarı -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-blue-600"></i>
                                    Yeni Şifre Tekrarı
                                </label>
                                <div class="relative">
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        required
                                        x-model="passwordConfirmation"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        :class="{ 'border-red-500': passwordConfirmation.length > 0 && !passwordsMatch, 'border-green-500': passwordConfirmation.length > 0 && passwordsMatch }"
                                        placeholder="Yeni şifrenizi tekrar giriniz"
                                    >
                                </div>
                                <p class="mt-1 text-xs" x-show="passwordConfirmation.length > 0">
                                    <span :class="passwordsMatch ? 'text-green-600' : 'text-red-600'">
                                        <i :class="passwordsMatch ? 'fas fa-check' : 'fas fa-times'" class="mr-1"></i>
                                        <span x-text="passwordsMatch ? 'Şifreler eşleşiyor' : 'Şifreler eşleşmiyor'"></span>
                                    </span>
                                </p>
                            </div>

                            <!-- Kaydet Butonu -->
                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium"
                                >
                                    <i class="fas fa-key mr-2"></i>
                                    Şifreyi Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sistemim Tab -->
                <div x-show="activeTab === 'system'" x-transition>
                    <div class="max-w-2xl">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Sistem Bilgilerim</h3>
                        <p class="text-sm text-gray-600 mb-6">Bilgisayarınızın donanım bilgilerini girin.</p>

                        <form action="{{ route('profile.system') }}" method="POST" class="space-y-6" x-data="systemForm()">
                            @csrf

                            <!-- Sistem Adı -->
                            <div>
                                <label for="system_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-desktop mr-2 text-blue-600"></i>
                                    Sistem Adı (İsteğe Bağlı)
                                </label>
                                <input
                                    type="text"
                                    id="system_name"
                                    name="system_name"
                                    value="{{ old('system_name', $userSystem->system_name ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Örn: Oyun Bilgisayarım"
                                >
                            </div>

                            <!-- CPU Seçimi -->
                            <div>
                                <label for="cpu_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-microchip mr-2 text-blue-600"></i>
                                    İşlemci (CPU)
                                </label>
                                <select
                                    id="cpu_id"
                                    name="cpu_id"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('cpu_id') border-red-500 @enderror"
                                >
                                    <option value="">İşlemci seçiniz</option>
                                    @php $currentBrand = null; @endphp
                                    @foreach($cpuModels as $cpu)
                                        @if($currentBrand !== $cpu->brand->name)
                                            @if($currentBrand !== null)
                                                </optgroup>
                                            @endif
                                            <optgroup label="{{ $cpu->brand->name }}">
                                            @php $currentBrand = $cpu->brand->name; @endphp
                                        @endif
                                        <option value="{{ $cpu->id }}" {{ old('cpu_id', $userSystem->cpu_id ?? '') == $cpu->id ? 'selected' : '' }}>
                                            {{ $cpu->name }}
                                        </option>
                                    @endforeach
                                    @if($currentBrand !== null)
                                        </optgroup>
                                    @endif
                                </select>
                                @error('cpu_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- GPU Seçimi -->
                            <div>
                                <label for="gpu_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tv mr-2 text-blue-600"></i>
                                    Ekran Kartı (GPU)
                                </label>
                                <select
                                    id="gpu_id"
                                    name="gpu_id"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('gpu_id') border-red-500 @enderror"
                                >
                                    <option value="">Ekran kartı seçiniz</option>
                                    @php $currentBrand = null; @endphp
                                    @foreach($gpuModels as $gpu)
                                        @if($currentBrand !== $gpu->brand->name)
                                            @if($currentBrand !== null)
                                                </optgroup>
                                            @endif
                                            <optgroup label="{{ $gpu->brand->name }}">
                                            @php $currentBrand = $gpu->brand->name; @endphp
                                        @endif
                                        <option value="{{ $gpu->id }}" {{ old('gpu_id', $userSystem->gpu_id ?? '') == $gpu->id ? 'selected' : '' }}>
                                            {{ $gpu->name }}
                                        </option>
                                    @endforeach
                                    @if($currentBrand !== null)
                                        </optgroup>
                                    @endif
                                </select>
                                @error('gpu_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RAM ve Disk -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="ram" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-memory mr-2 text-blue-600"></i>
                                        RAM (GB)
                                    </label>
                                    <input
                                        type="number"
                                        id="ram"
                                        name="ram"
                                        value="{{ old('ram', $userSystem->ram ?? '') }}"
                                        required
                                        min="1"
                                        max="256"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('ram') border-red-500 @enderror"
                                        placeholder="8"
                                    >
                                    @error('ram')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="disk" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-hdd mr-2 text-blue-600"></i>
                                        Disk Alanı (GB)
                                    </label>
                                    <input
                                        type="number"
                                        id="disk"
                                        name="disk"
                                        value="{{ old('disk', $userSystem->disk ?? '') }}"
                                        required
                                        min="1"
                                        max="10000"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('disk') border-red-500 @enderror"
                                        placeholder="500"
                                    >
                                    @error('disk')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mevcut Sistem Bilgisi -->
                            @if($userSystem)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-blue-900 mb-2">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Mevcut Sistem Bilgileriniz
                                    </h4>
                                    <div class="text-sm text-blue-800 space-y-1">
                                        <p><strong>CPU:</strong> {{ $userSystem->cpu->name }}</p>
                                        <p><strong>GPU:</strong> {{ $userSystem->gpu->name }}</p>
                                        <p><strong>RAM:</strong> {{ $userSystem->ram }} GB</p>
                                        <p><strong>Disk:</strong> {{ $userSystem->disk }} GB</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Kaydet Butonu -->
                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium"
                                >
                                    <i class="fas fa-save mr-2"></i>
                                    Sistem Bilgilerini Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function profileTabs() {
    return {
        activeTab: '{{ session('activeTab', 'profile') }}',

        init() {
            // Hash'e göre aktif tab'ı belirle
            const hash = window.location.hash.substring(1);
            if (hash && ['profile', 'rank', 'password', 'system'].includes(hash)) {
                this.activeTab = hash;
            }

            // Tab değiştiğinde URL'yi güncelle
            this.$watch('activeTab', (value) => {
                window.history.replaceState(null, null, '#' + value);
            });
        }
    }
}

function passwordForm() {
    return {
        password: '',
        passwordConfirmation: '',
        passwordStrength: 0,

        get passwordsMatch() {
            return this.password === this.passwordConfirmation && this.passwordConfirmation.length > 0;
        },

        get passwordStrengthText() {
            switch(this.passwordStrength) {
                case 1: return 'Zayıf şifre';
                case 2: return 'Orta güçlükte şifre';
                case 3: return 'Güçlü şifre';
                default: return '';
            }
        },

        get passwordStrengthColor() {
            switch(this.passwordStrength) {
                case 1: return 'text-red-600';
                case 2: return 'text-yellow-600';
                case 3: return 'text-green-600';
                default: return 'text-gray-600';
            }
        },

        validatePassword() {
            let strength = 0;

            if (this.password.length >= 6) strength++;
            if (this.password.match(/[a-z]/) && this.password.match(/[A-Z]/)) strength++;
            if (this.password.match(/[0-9]/) && this.password.match(/[^a-zA-Z0-9]/)) strength++;

            this.passwordStrength = strength;
        }
    }
}

function systemForm() {
    return {
        // Sistem formu için gelecekte eklenebilecek özellikler
    }
}
</script>
@endpush

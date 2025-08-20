@extends('layouts.admin')

@section('title', $game->name . ' - Oyun Detayı')
@section('page-title', $game->name)
@section('page-description', 'Oyun detayları ve sistem gereksinimleri')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('admin.games.index') }}" class="text-gray-700 hover:text-blue-600">Oyun Yönetimi</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">{{ $game->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div></div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.games.edit', $game->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Düzenle
            </a>
            <a href="{{ route('game.show', $game->id) }}"
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-external-link-alt mr-2"></i>
                Önizle
            </a>
            <form action="{{ route('admin.games.destroy', $game->id) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('Bu oyunu silmek istediğinizden emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Sil
                </button>
            </form>
        </div>
    </div>

    <!-- Game Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Temel Bilgiler
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Oyun Adı</label>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $game->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Puan</label>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            @if($game->score)
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i>
                                        {{ $game->score }}/10
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">Puanlanmamış</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $game->description }}</p>
                </div>
            </div>

            <!-- System Requirements -->
            @if($game->requirements->count() > 0)
                @foreach($game->requirements->groupBy('type') as $type => $requirements)
                    @foreach($requirements as $requirement)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-cogs mr-2 {{ $type === 'minimum' ? 'text-red-600' : 'text-green-600' }}"></i>
                                {{ $type === 'minimum' ? 'Minimum Sistem Gereksinimleri' : 'Önerilen Sistem Gereksinimleri' }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Memory & Storage -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-memory mr-1"></i>
                                            RAM
                                        </label>
                                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $requirement->ram }} GB</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-hdd mr-1"></i>
                                            Disk Alanı
                                        </label>
                                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $requirement->disk }} GB</p>
                                    </div>
                                </div>

                                <!-- Hardware -->
                                <div class="space-y-4">
                                    <!-- CPUs -->
                                    @if($requirement->cpus->count() > 0)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-microchip mr-1"></i>
                                                İşlemci (CPU)
                                            </label>
                                            <div class="space-y-2">
                                                @foreach($requirement->cpus->groupBy('brand.name') as $brandName => $cpus)
                                                    <div class="bg-gray-50 p-3 rounded-lg">
                                                        <div class="text-xs font-medium text-gray-600 mb-1">{{ $brandName }}</div>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($cpus as $cpu)
                                                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                                                                    {{ $cpu->name }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- GPUs -->
                                    @if($requirement->gpus->count() > 0)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-tv mr-1"></i>
                                                Ekran Kartı (GPU)
                                            </label>
                                            <div class="space-y-2">
                                                @foreach($requirement->gpus->groupBy('brand.name') as $brandName => $gpus)
                                                    <div class="bg-gray-50 p-3 rounded-lg">
                                                        <div class="text-xs font-medium text-gray-600 mb-1">{{ $brandName }}</div>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($gpus as $gpu)
                                                                <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                                                                    {{ $gpu->name }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Sistem Gereksinimi Yok</h3>
                    <p class="text-gray-500">Bu oyun için henüz sistem gereksinimi tanımlanmamış.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Game Image -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Oyun Resmi</h4>
                <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    @if($game->image)
                        <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <div class="text-white text-center">
                            <i class="fas fa-gamepad text-4xl mb-2"></i>
                            <p class="text-sm">Resim yok</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Hızlı Bilgiler</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Oluşturulma:</span>
                        <span class="text-sm font-medium">{{ $game->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Güncellenme:</span>
                        <span class="text-sm font-medium">{{ $game->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Gereksinim Sayısı:</span>
                        <span class="text-sm font-medium">{{ $game->requirements->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Toplam CPU:</span>
                        <span class="text-sm font-medium">{{ $game->requirements->sum(function($req) { return $req->cpus->count(); }) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Toplam GPU:</span>
                        <span class="text-sm font-medium">{{ $game->requirements->sum(function($req) { return $req->gpus->count(); }) }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">İşlemler</h4>
                <div class="space-y-3">
                    <a href="{{ route('admin.games.edit', $game->id) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Düzenle
                    </a>
                    <a href="{{ route('game.show', $game->id) }}"
                       target="_blank"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Önizle
                    </a>
                    <a href="{{ route('admin.games.index') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Geri Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

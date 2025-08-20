@extends('layouts.app')

@section('title', $game->name . ' - Sistem Uyumluluk Testi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                🖥️ Sistem Uyumluluk Testi
            </h1>
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $game->name }}</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Sisteminizin bu oyunu çalıştırabilme durumunu analiz ediyoruz
            </p>
        </div>

        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('game.show', $game->id) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Oyun Detayına Dön
            </a>
        </div>

        <!-- Sistem Karşılaştırması -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Kullanıcının Sistemi -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-desktop mr-3"></i>
                        Sisteminiz
                    </h3>
                    <p class="text-blue-100 text-sm mt-1">{{ $userSystem->name }}</p>
                </div>
                <div class="p-6 space-y-4">
                    <!-- CPU -->
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-microchip text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $userSystem->cpu->brand->name ?? 'Bilinmiyor' }}</div>
                            <div class="text-sm text-gray-600">{{ $userSystem->cpu->name ?? 'Belirtilmemiş' }}</div>
                        </div>
                    </div>

                    <!-- GPU -->
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-tv text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $userSystem->gpu->brand->name ?? 'Bilinmiyor' }}</div>
                            <div class="text-sm text-gray-600">{{ $userSystem->gpu->name ?? 'Belirtilmemiş' }}</div>
                        </div>
                    </div>

                    <!-- RAM -->
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-memory text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $userSystem->ram }} GB</div>
                            <div class="text-sm text-gray-600">Sistem Belleği</div>
                        </div>
                    </div>

                    <!-- Disk -->
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-hdd text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $userSystem->disk }} GB</div>
                            <div class="text-sm text-gray-600">Depolama Alanı</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Minimum Gereksinimler -->
            @if($game->minimumRequirements)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        Minimum Gereksinimler
                    </h3>
                    <p class="text-red-100 text-sm mt-1">Oyunu çalıştırmak için gerekli</p>
                </div>
                <div class="p-6 space-y-4">
                    <!-- CPU -->
                    <div class="p-3 rounded-lg {{ $comparison['minimum']['cpu_compatible'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['minimum']['cpu_compatible'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                    <i class="fas fa-microchip {{ $comparison['minimum']['cpu_compatible'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">İşlemci Seçenekleri</div>
                                    <div class="text-sm text-gray-600">{{ $game->minimumRequirements->cpus->count() }} adet uyumlu</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @if($comparison['minimum']['cpu_compatible'] == 'sufficient')
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                @else
                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-2">
                            @if($game->minimumRequirements->cpus->count() > 0)
                                @foreach($game->minimumRequirements->cpus as $cpu)
                                    <div class="flex items-center p-2 bg-white rounded border text-sm">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-blue-100">
                                            <i class="fas fa-microchip text-blue-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">{{ $cpu->brand->name }}</span>
                                            <span class="text-gray-600">{{ $cpu->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center p-3 bg-gray-50 rounded border text-sm">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-gray-100">
                                        <i class="fas fa-info text-gray-600 text-xs"></i>
                                    </div>
                                    <div class="text-gray-600">
                                        Sisteminizin markasına uygun seçenek bulunamadı
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- GPU -->
                    <div class="p-3 rounded-lg {{ $comparison['minimum']['gpu_compatible'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['minimum']['gpu_compatible'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                    <i class="fas fa-tv {{ $comparison['minimum']['gpu_compatible'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">Ekran Kartı Seçenekleri</div>
                                    <div class="text-sm text-gray-600">{{ $game->minimumRequirements->gpus->count() }} adet uyumlu</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @if($comparison['minimum']['gpu_compatible'] == 'sufficient')
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                @else
                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-2">
                            @if($game->minimumRequirements->gpus->count() > 0)
                                @foreach($game->minimumRequirements->gpus as $gpu)
                                    <div class="flex items-center p-2 bg-white rounded border text-sm">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-green-100">
                                            <i class="fas fa-tv text-green-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">{{ $gpu->brand->name }}</span>
                                            <span class="text-gray-600">{{ $gpu->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center p-3 bg-gray-50 rounded border text-sm">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-gray-100">
                                        <i class="fas fa-info text-gray-600 text-xs"></i>
                                    </div>
                                    <div class="text-gray-600">
                                        Sisteminizin markasına uygun seçenek bulunamadı
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- RAM -->
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $comparison['minimum']['ram'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['minimum']['ram'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                <i class="fas fa-memory {{ $comparison['minimum']['ram'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $game->minimumRequirements->ram ?? 'N/A' }} GB RAM</div>
                                <div class="text-sm text-gray-600">Minimum bellek</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if($comparison['minimum']['ram'] == 'sufficient')
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            @else
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Disk -->
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $comparison['minimum']['disk'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['minimum']['disk'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                <i class="fas fa-hdd {{ $comparison['minimum']['disk'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $game->minimumRequirements->disk ?? 'N/A' }} GB</div>
                                <div class="text-sm text-gray-600">Disk alanı</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if($comparison['minimum']['disk'] == 'sufficient')
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            @else
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Önerilen Gereksinimler -->
            @if($game->recommendedRequirements && $comparison['recommended'])
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-star mr-3"></i>
                        Önerilen Gereksinimler
                    </h3>
                    <p class="text-green-100 text-sm mt-1">En iyi deneyim için</p>
                </div>
                <div class="p-6 space-y-4">
                    <!-- CPU -->
                    <div class="p-3 rounded-lg {{ $comparison['recommended']['cpu_compatible'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['recommended']['cpu_compatible'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                    <i class="fas fa-microchip {{ $comparison['recommended']['cpu_compatible'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">İşlemci Seçenekleri</div>
                                    <div class="text-sm text-gray-600">{{ $game->recommendedRequirements->cpus->count() }} adet uyumlu</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @if($comparison['recommended']['cpu_compatible'] == 'sufficient')
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                @else
                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-2">
                            @if($game->recommendedRequirements->cpus->count() > 0)
                                @foreach($game->recommendedRequirements->cpus as $cpu)
                                    <div class="flex items-center p-2 bg-white rounded border text-sm">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-blue-100">
                                            <i class="fas fa-microchip text-blue-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">{{ $cpu->brand->name }}</span>
                                            <span class="text-gray-600">{{ $cpu->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center p-3 bg-gray-50 rounded border text-sm">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-gray-100">
                                        <i class="fas fa-info text-gray-600 text-xs"></i>
                                    </div>
                                    <div class="text-gray-600">
                                        Sisteminizin markasına uygun seçenek bulunamadı
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- GPU -->
                    <div class="p-3 rounded-lg {{ $comparison['recommended']['gpu_compatible'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['recommended']['gpu_compatible'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                    <i class="fas fa-tv {{ $comparison['recommended']['gpu_compatible'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">Ekran Kartı Seçenekleri</div>
                                    <div class="text-sm text-gray-600">{{ $game->recommendedRequirements->gpus->count() }} adet uyumlu</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @if($comparison['recommended']['gpu_compatible'] == 'sufficient')
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                @else
                                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-2">
                            @if($game->recommendedRequirements->gpus->count() > 0)
                                @foreach($game->recommendedRequirements->gpus as $gpu)
                                    <div class="flex items-center p-2 bg-white rounded border text-sm">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-green-100">
                                            <i class="fas fa-tv text-green-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800">{{ $gpu->brand->name }}</span>
                                            <span class="text-gray-600">{{ $gpu->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center p-3 bg-gray-50 rounded border text-sm">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 bg-gray-100">
                                        <i class="fas fa-info text-gray-600 text-xs"></i>
                                    </div>
                                    <div class="text-gray-600">
                                        Sisteminizin markasına uygun seçenek bulunamadı
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- RAM -->
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $comparison['recommended']['ram'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['recommended']['ram'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                <i class="fas fa-memory {{ $comparison['recommended']['ram'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $game->recommendedRequirements->ram ?? 'N/A' }} GB RAM</div>
                                <div class="text-sm text-gray-600">Önerilen bellek</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if($comparison['recommended']['ram'] == 'sufficient')
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            @else
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Disk -->
                    <div class="flex items-center justify-between p-3 rounded-lg {{ $comparison['recommended']['disk'] == 'sufficient' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 {{ $comparison['recommended']['disk'] == 'sufficient' ? 'bg-green-100' : 'bg-red-100' }}">
                                <i class="fas fa-hdd {{ $comparison['recommended']['disk'] == 'sufficient' ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $game->recommendedRequirements->disk ?? 'N/A' }} GB</div>
                                <div class="text-sm text-gray-600">Disk alanı</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if($comparison['recommended']['disk'] == 'sufficient')
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            @else
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Genel Sonuç -->
        <div class="mt-12">
            @php
                $minCompatible = collect($comparison['minimum'])->every(fn($status) => $status === 'sufficient');
                $recCompatible = $comparison['recommended'] ?
                    collect($comparison['recommended'])->every(fn($status) => $status === 'sufficient') : false;
            @endphp

            @if($minCompatible && $recCompatible)
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-8 text-center shadow-xl">
                    <i class="fas fa-check-circle text-6xl text-white mb-4"></i>
                    <h3 class="text-3xl font-bold text-white mb-2">Mükemmel Uyumluluk!</h3>
                    <p class="text-green-100 text-lg">Sisteminiz bu oyunu sorunsuz bir şekilde çalıştırabilir ve en iyi deneyimi yaşayabilirsiniz.</p>
                </div>
            @elseif($minCompatible)
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl p-8 text-center shadow-xl">
                    <i class="fas fa-exclamation-circle text-6xl text-white mb-4"></i>
                    <h3 class="text-3xl font-bold text-white mb-2">Oynanabilir</h3>
                    <p class="text-yellow-100 text-lg">Sisteminiz minimum gereksinimleri karşılıyor. Oyun çalışacak ama performans sınırlı olabilir.</p>
                </div>
            @else
                <div class="bg-gradient-to-r from-red-600 to-pink-600 rounded-xl p-8 text-center shadow-xl">
                    <i class="fas fa-times-circle text-6xl text-white mb-4"></i>
                    <h3 class="text-3xl font-bold text-white mb-2">Uyumsuz Sistem</h3>
                    <p class="text-red-100 text-lg">Maalesef sisteminiz bu oyunu çalıştırmak için yeterli değil. Donanımınızı güncellemen gerekebilir.</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-12">
            <a href="{{ route('game.show', $game->id) }}"
               class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Oyun Detayına Dön
            </a>
            <a href="{{ route('profile.index', ['tab' => 'system']) }}"
               class="px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center">
                <i class="fas fa-cog mr-2"></i>
                Sistem Bilgilerimi Güncelle
            </a>
        </div>

    </div>
</div>
@endsection

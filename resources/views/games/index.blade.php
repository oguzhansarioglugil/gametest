@extends('layouts.app')

@section('title', 'Tüm Oyunlar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                🎮 Tüm Oyunlar
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Oyun kütüphanemizde bulunan tüm oyunları keşfedin ve sistem gereksinimlerini inceleyin
            </p>
        </div>

        <!-- Search Section -->
        <div class="mb-8">
            <form method="GET" action="{{ route('games.index') }}" class="max-w-md mx-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Oyun ara..."
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-3 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            Ara
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <div class="text-gray-600 mb-4 sm:mb-0">
                    @if(request('search'))
                        <span class="font-medium">{{ $games->total() }}</span> oyun bulundu
                        "<span class="font-semibold text-blue-600">{{ request('search') }}</span>" araması için
                    @else
                        Toplam <span class="font-medium">{{ $games->total() }}</span> oyun
                    @endif
                </div>

                @if(request('search'))
                    <a href="{{ route('games.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Aramayı Temizle
                    </a>
                @endif
            </div>
        </div>

        <!-- Games Grid -->
        @if($games->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8 items-stretch">
                @foreach($games as $game)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group h-full flex flex-col">
                        <!-- Game Image -->
                        <div class="relative h-48 bg-gradient-to-br from-blue-500 to-purple-600 overflow-hidden flex-shrink-0">
                            @if($game->image)
                                <img src="{{ asset('storage/' . $game->image) }}"
                                     alt="{{ $game->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center text-white">
                                        <svg class="w-16 h-16 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                                        </svg>
                                        <p class="text-sm font-medium">{{ $game->name }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Score Badge -->
                            @if($game->score)
                                <div class="absolute top-3 right-3">
                                    <div class="bg-black bg-opacity-70 text-white px-2 py-1 rounded-lg text-sm font-bold">
                                        ⭐ {{ number_format($game->score, 1) }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Game Info -->
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $game->name }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                                {{ Str::limit($game->description, 120) }}
                            </p>

                            <!-- Requirements Preview -->
                            @if($game->requirements->count() > 0)
                                <div class="mb-4 flex-shrink-0">
                                    <div class="text-xs text-gray-500 mb-2">Sistem Gereksinimleri:</div>
                                    @php
                                        $minReq = $game->requirements->where('type', 'minimum')->first();
                                    @endphp
                                    @if($minReq)
                                        <div class="space-y-1 text-xs">
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">RAM:</span>
                                                <span class="font-medium">{{ $minReq->ram ?? 'N/A' }} GB</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500">Disk:</span>
                                                <span class="font-medium">{{ $minReq->disk ?? 'N/A' }} GB</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Button - En alta sabitlendi -->
                            <a href="{{ route('game.show', $game->id) }}"
                               class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 text-center block mt-auto">
                                Detayları Görüntüle
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 mb-8">
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl shadow-xl p-8 border border-gray-100">
                    <!-- Stats Section -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center space-x-2 bg-white rounded-full px-6 py-3 shadow-md">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-lg font-semibold text-gray-700">
                                {{ $games->firstItem() }}-{{ $games->lastItem() }} arası gösteriliyor
                            </span>
                            <div class="w-px h-4 bg-gray-300"></div>
                            <span class="text-lg font-bold text-blue-600">
                                {{ $games->total() }} toplam oyun
                            </span>
                        </div>
                    </div>

                    <!-- Pagination Navigation -->
                    <div class="flex flex-col items-center space-y-6">
                        <!-- Page Info -->
                        <div class="text-center">
                            <div class="text-sm text-gray-600 mb-2">Sayfa Navigasyonu</div>
                            <div class="text-2xl font-bold text-gray-800">
                                Sayfa <span class="text-blue-600">{{ $games->currentPage() }}</span> /
                                <span class="text-purple-600">{{ $games->lastPage() }}</span>
                            </div>
                        </div>

                        <!-- Custom Pagination -->
                        <div class="flex items-center space-x-2">
                            @if ($games->onFirstPage())
                                <span class="px-4 py-3 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $games->previousPageUrl() }}" class="px-4 py-3 text-blue-600 bg-white hover:bg-blue-50 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 border border-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @endif

                            @foreach ($games->getUrlRange(1, $games->lastPage()) as $page => $url)
                                @if ($page == $games->currentPage())
                                    <span class="px-5 py-3 text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg font-bold text-lg min-w-[3rem] text-center">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-5 py-3 text-gray-700 bg-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 border border-gray-200 font-medium min-w-[3rem] text-center">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($games->hasMorePages())
                                <a href="{{ $games->nextPageUrl() }}" class="px-4 py-3 text-blue-600 bg-white hover:bg-blue-50 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 border border-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="px-4 py-3 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>

                        <!-- Quick Jump (sadece çok sayfalı durumda) -->
                        @if($games->lastPage() > 5)
                            <div class="flex items-center space-x-3 mt-4">
                                <span class="text-sm text-gray-600">Hızlı Git:</span>
                                <a href="{{ $games->url(1) }}" class="px-3 py-2 text-xs font-medium text-blue-600 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors">
                                    İlk Sayfa
                                </a>
                                <a href="{{ $games->url($games->lastPage()) }}" class="px-3 py-2 text-xs font-medium text-purple-600 bg-purple-100 hover:bg-purple-200 rounded-lg transition-colors">
                                    Son Sayfa
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.5-.816-6.207-2.175.277-.193.559-.39.844-.59A4.973 4.973 0 0112 13.5c2.122 0 3.879-1.168 4.363-2.825A7.962 7.962 0 0112 9c-2.34 0-4.5.816-6.207 2.175a15.934 15.934 0 01-.844.59 4.973 4.973 0 00-1.949 3.735c0 .414.336.75.75.75h.5a.75.75 0 00.75-.75 3.223 3.223 0 011.949-2.985A15.934 15.934 0 0112 9a7.962 7.962 0 016.207 2.175c-.277.193-.559.39-.844.59A4.973 4.973 0 0112 13.5a7.962 7.962 0 01-6.207-2.175 15.934 15.934 0 01.844-.59A4.973 4.973 0 0112 9c2.34 0 4.5.816 6.207 2.175-.277.193-.559.39-.844.59A4.973 4.973 0 0112 13.5c-2.122 0-3.879 1.168-4.363 2.825z"></path>
                    </svg>

                    @if(request('search'))
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Arama sonucu bulunamadı</h3>
                        <p class="text-gray-600 mb-6">
                            "<span class="font-semibold">{{ request('search') }}</span>" araması için hiçbir oyun bulunamadı.
                        </p>
                        <a href="{{ route('games.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Tüm Oyunları Görüntüle
                        </a>
                    @else
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Henüz oyun eklenmemiş</h3>
                        <p class="text-gray-600">
                            Oyun kütüphanemiz şu anda boş. Yakında harika oyunlar eklenecek!
                        </p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Grid kartlarının eşit yükseklikte olması için */
.grid.items-stretch > * {
    height: 100%;
}

/* Hover efektleri */
.group:hover {
    transform: translateY(-5px);
}
</style>

<script>
// Check for hardware parameters from Python analyzer
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);

    // Check if hardware data exists in URL
    if (urlParams.has('hardware') && urlParams.get('hardware') === '1') {
        console.log('🔧 Donanım bilgileri URL parametrelerinden alınıyor...');

        // Extract hardware data from URL parameters
        const hardwareData = {
            cpu_name: urlParams.get('cpu') || 'Unknown CPU',
            gpu_name: urlParams.get('gpu') || 'Unknown GPU',
            ram_gb: parseInt(urlParams.get('ram')) || 0,
            disk_free_gb: parseInt(urlParams.get('disk')) || 0,
            os: urlParams.get('os') || 'Unknown OS',
            cpu_cores: parseInt(urlParams.get('cores')) || null,
            cpu_threads: parseInt(urlParams.get('threads')) || null,
            gpu_memory_gb: parseInt(urlParams.get('gpu_mem')) || 0,
            analyzed_at: new Date().toISOString()
        };

        console.log('📊 Elde edilen donanım bilgileri:', hardwareData);

        try {
            // Save to localStorage
            localStorage.setItem('system_hardware', JSON.stringify(hardwareData));
            console.log('✅ localStorage başarıyla kaydedildi!');

            // Verify save
            const saved = localStorage.getItem('system_hardware');
            if (saved) {
                console.log('✅ Doğrulama başarılı:', JSON.parse(saved));

                // Show success notification
                showNotification('✅ Sistem bilgileriniz başarıyla kaydedildi!', 'success');

                // Clean URL (remove parameters)
                const cleanUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);

            } else {
                throw new Error('localStorage doğrulaması başarısız');
            }
        } catch (error) {
            console.error('❌ localStorage hatası:', error);
            showNotification('❌ Sistem bilgileri kaydedilirken hata oluştu!', 'error');
        }
    }
});

// Show notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300 transform translate-x-full`;

    if (type === 'success') {
        notification.classList.add('bg-green-500', 'text-white');
    } else if (type === 'error') {
        notification.classList.add('bg-red-500', 'text-white');
    } else {
        notification.classList.add('bg-blue-500', 'text-white');
    }

    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Slide in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}
</script>
@endsection

@extends('layouts.app')

@section('title', 'Anasayfa - GameTest')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Oyun Sistem Karşılaştırma</h1>
        <p class="text-xl mb-8 text-gray-200 max-w-2xl mx-auto">
            Bilgisayarınızın hangi oyunları çalıştırabileceğini öğrenin. Sistem gereksinimlerini karşılaştırın ve en iyi oyun deneyimi için donanım önerilerimizi inceleyin.
        </p>

        <!-- Arama Formu -->
        <div class="max-w-2xl mx-auto" x-data="liveSearch()">
            <form action="{{ route('home') }}" method="GET" class="relative">
                <div class="flex">
                    <input
                        type="text"
                        name="search"
                        x-model="searchQuery"
                        @input="performSearch()"
                        placeholder="Oyun adı yazın... (örn: GTA, Cyberpunk, Elden Ring)"
                        class="flex-1 px-6 py-4 text-lg text-gray-800 bg-white rounded-l-xl border-0 focus:ring-4 focus:ring-purple-300 search-focus outline-none"
                    >
                    <button
                        type="submit"
                        class="px-8 py-4 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-r-xl transition-colors flex items-center space-x-2"
                    >
                        <i class="fas fa-search" :class="{ 'fa-spin': loading }"></i>
                        <span x-text="loading ? 'Aranıyor...' : 'Ara'"></span>
                    </button>
                </div>
            </form>

            <!-- Hızlı Arama Önerileri -->
            <div class="mt-4 flex flex-wrap justify-center gap-2">
                <span class="text-gray-200 text-sm">Popüler aramalar:</span>
                @foreach(['GTA', 'Cyberpunk', 'Elden Ring', 'Red Dead'] as $suggestion)
                    <button
                        @click="searchQuery = '{{ $suggestion }}'; performSearch()"
                        class="px-3 py-1 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full text-sm transition-colors cursor-pointer"
                    >
                        {{ $suggestion }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Oyunlar Bölümü -->
<section class="py-16" x-data="searchResults()" @search-updated.window="searchTerm = $event.detail.searchTerm; gameCount = $event.detail.gameCount">
    <div class="container mx-auto px-4">
        <!-- Başlık -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4" x-text="searchTerm ? `'${searchTerm}' için arama sonuçları` : 'Popüler Oyunlar'"></h2>
            <p class="text-gray-600" x-text="searchTerm ? `${gameCount} oyun bulundu` : 'En çok aranan oyunlar ve sistem gereksinimleri'"></p>
        </div>

        <!-- Oyun Kartları -->
        <div x-show="gameCount > 0" x-transition>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-stretch" id="games-container">
                @foreach($games as $game)
                    @include('partials.game-card', ['game' => $game])
                @endforeach
            </div>
        </div>

        <!-- Oyun Bulunamadı -->
        <div x-show="gameCount === 0" x-transition class="text-center py-16">
            <div class="max-w-md mx-auto">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Oyun Bulunamadı</h3>
                <p class="text-gray-500 mb-6" x-text="searchTerm ? `'${searchTerm}' için herhangi bir oyun bulunamadı. Farklı bir arama terimi deneyin.` : 'Henüz hiç oyun eklenmemiş.'"></p>
                <button @click="searchQuery = ''; performSearch()" class="inline-flex items-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-home mr-2"></i>
                    Tüm Oyunları Göster
                </button>
            </div>
        </div>
    </div>
</section>

<!-- İstatistikler -->
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ \App\Models\Game::count() }}</div>
                <div class="text-gray-600">Toplam Oyun</div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ \App\Models\HardwareModel::where('type', 'cpu')->count() }}</div>
                <div class="text-gray-600">CPU Modeli</div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ \App\Models\HardwareModel::where('type', 'gpu')->count() }}</div>
                <div class="text-gray-600">GPU Modeli</div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-lg">
                <div class="text-3xl font-bold text-red-600 mb-2">{{ \App\Models\GameRequirement::count() }}</div>
                <div class="text-gray-600">Sistem Gereksinimi</div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    /* Grid kartlarının eşit yükseklikte olması için */
    .grid.items-stretch > * {
        height: 100%;
    }
</style>
@endpush

@push('scripts')
<script>
function liveSearch() {
    return {
        searchQuery: '{{ request('search') }}',
        loading: false,
        searchTimeout: null,

        performSearch() {
            // Önceki timeout'u temizle
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            // 300ms bekle (debounce)
            this.searchTimeout = setTimeout(() => {
                this.doSearch();
            }, 300);
        },

        async doSearch() {
            this.loading = true;

            try {
                const response = await fetch(`{{ route('api.search') }}?search=${encodeURIComponent(this.searchQuery)}`);
                const data = await response.json();

                // Başlık ve sayaç güncelle
                this.updateSearchResults(data);

                // Oyun kartlarını güncelle
                this.updateGameCards(data.games);

            } catch (error) {
                console.error('Arama hatası:', error);
            } finally {
                this.loading = false;
            }
        },

        updateSearchResults(data) {
            // Diğer Alpine.js bileşenlerine veri gönder
            this.$dispatch('search-updated', {
                searchTerm: data.search_term,
                gameCount: data.count
            });
        },

        updateGameCards(games) {
            const container = document.getElementById('games-container');

            if (games.length === 0) {
                container.innerHTML = '';
                return;
            }

            // Yeni kartları oluştur
            let cardsHtml = '';
            games.forEach(game => {
                cardsHtml += this.createGameCard(game);
            });

            // Fade out -> update -> fade in efekti
            container.style.opacity = '0.5';
            setTimeout(() => {
                container.innerHTML = cardsHtml;
                container.style.opacity = '1';
                container.classList.add('fade-in');
            }, 150);
        },

        createGameCard(game) {
            const hasImage = game.image && game.image !== '';
            const imageHtml = hasImage
                ? `<img src="/storage/${game.image}" alt="${game.name}" class="w-full h-full object-cover">`
                : `<div class="text-white text-center">
                     <i class="fas fa-gamepad text-4xl mb-2"></i>
                     <p class="text-sm font-medium">${game.name}</p>
                   </div>`;

            const starsHtml = this.createStarsHtml(game.score);
            const minReqHtml = game.minimum_requirements
                ? `<div class="bg-gray-50 rounded-lg p-3 mb-4 flex-shrink-0">
                     <h4 class="text-xs font-semibold text-gray-700 mb-2">Minimum Gereksinimler</h4>
                     <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                       <div><i class="fas fa-memory text-blue-500"></i> <span class="ml-1">${game.minimum_requirements.ram} GB RAM</span></div>
                       <div><i class="fas fa-hdd text-green-500"></i> <span class="ml-1">${game.minimum_requirements.disk} GB</span></div>
                     </div>
                   </div>`
                : '';

            return `
                <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover h-full flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center flex-shrink-0">
                        ${imageHtml}
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">${game.name}</h3>
                        ${game.score ? `<div class="flex items-center mb-3">${starsHtml}<span class="ml-2 text-sm text-gray-600">${game.score}/10</span></div>` : ''}
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">${this.limitText(game.description, 100)}</p>
                        ${minReqHtml}
                        <a href="/game/${game.id}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-3 rounded-lg font-semibold transition-colors mt-auto">
                            <i class="fas fa-info-circle mr-2"></i>
                            Detayları Gör
                        </a>
                    </div>
                </div>
            `;
        },

        createStarsHtml(score) {
            if (!score) return '';

            let starsHtml = '<div class="flex items-center space-x-1">';
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.floor(score / 2)) {
                    starsHtml += '<i class="fas fa-star text-yellow-400"></i>';
                } else if (i === Math.ceil(score / 2) && score % 2 !== 0) {
                    starsHtml += '<i class="fas fa-star-half-alt text-yellow-400"></i>';
                } else {
                    starsHtml += '<i class="far fa-star text-gray-300"></i>';
                }
            }
            starsHtml += '</div>';
            return starsHtml;
        },

        limitText(text, limit) {
            if (text.length <= limit) return text;
            return text.substring(0, limit) + '...';
        }
    }
}

// Search results listener
document.addEventListener('alpine:init', () => {
    Alpine.data('searchResults', () => ({
        searchTerm: '{{ request('search') }}',
        gameCount: {{ $games->count() }},

        init() {
            this.$watch('searchTerm', () => {
                // URL'yi güncelle (opsiyonel)
                if (this.searchTerm) {
                    window.history.replaceState({}, '', `?search=${encodeURIComponent(this.searchTerm)}`);
                } else {
                    window.history.replaceState({}, '', '/');
                }
            });

            // Search updated event listener
            this.$el.addEventListener('search-updated', (event) => {
                this.searchTerm = event.detail.searchTerm;
                this.gameCount = event.detail.gameCount;
            });
        }
    }));
});
</script>
@endpush

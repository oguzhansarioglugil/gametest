<div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover h-full flex flex-col">
    <!-- Oyun Resmi -->
    <div class="h-48 bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center flex-shrink-0">
        @if($game->image)
            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
        @else
            <div class="text-white text-center">
                <i class="fas fa-gamepad text-4xl mb-2"></i>
                <p class="text-sm font-medium">{{ $game->name }}</p>
            </div>
        @endif
    </div>

    <!-- Oyun Bilgileri -->
    <div class="p-6 flex flex-col flex-grow">
        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $game->name }}</h3>

        <!-- Puan -->
        @if($game->score)
            <div class="flex items-center mb-3">
                <div class="flex items-center space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($game->score / 2))
                            <i class="fas fa-star text-yellow-400"></i>
                        @elseif($i == ceil($game->score / 2) && $game->score % 2 != 0)
                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                        @else
                            <i class="far fa-star text-gray-300"></i>
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-sm text-gray-600">{{ $game->score }}/10</span>
            </div>
        @endif

        <!-- Açıklama -->
        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">{{ Str::limit($game->description, 100) }}</p>

        <!-- Sistem Gereksinimleri Özeti -->
        @if($game->minimumRequirements)
            <div class="bg-gray-50 rounded-lg p-3 mb-4 flex-shrink-0">
                <h4 class="text-xs font-semibold text-gray-700 mb-2">Minimum Gereksinimler</h4>
                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                    <div>
                        <i class="fas fa-memory text-blue-500"></i>
                        <span class="ml-1">{{ $game->minimumRequirements->ram }} GB RAM</span>
                    </div>
                    <div>
                        <i class="fas fa-hdd text-green-500"></i>
                        <span class="ml-1">{{ $game->minimumRequirements->disk }} GB</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Detay Butonu - En alta sabitlendi -->
        <a href="{{ route('game.show', $game->id) }}"
           class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-3 rounded-lg font-semibold transition-colors mt-auto">
            <i class="fas fa-info-circle mr-2"></i>
            Detayları Gör
        </a>
    </div>
</div>

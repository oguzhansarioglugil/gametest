@extends('layouts.admin')

@section('title', 'Oyun Yönetimi')
@section('page-title', 'Oyun Yönetimi')
@section('page-description', 'Sistemdeki tüm oyunları yönetin')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <!-- Search -->
        <div class="flex-1 max-w-md">
            <form method="GET" action="{{ route('admin.games.index') }}">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Oyun ara..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                </div>
            </form>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-3">
            <!-- Bulk Delete Button -->
            <button
                id="bulk-delete-btn"
                type="button"
                class="hidden inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors"
                onclick="confirmBulkDelete()">
                <i class="fas fa-trash mr-2"></i>
                Seçilenleri Sil
            </button>

            <!-- Add New Game Button -->
            <a href="{{ route('admin.games.create') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Yeni Oyun Ekle
            </a>
        </div>
    </div>

    <!-- Games Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <form id="bulk-delete-form" action="{{ route('admin.games.bulk-delete') }}" method="POST">
                @csrf
                @method('DELETE')

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input
                                    type="checkbox"
                                    id="select-all"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                >
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Oyun
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Puan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sistem Gereksinimleri
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Oluşturulma Tarihi
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($games as $game)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input
                                        type="checkbox"
                                        name="selected_games[]"
                                        value="{{ $game->id }}"
                                        class="game-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                            @if($game->image)
                                                <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <i class="fas fa-gamepad text-white"></i>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $game->name }}</div>
                                            <div class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($game->description, 60) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($game->score)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>
                                            {{ $game->score }}/10
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Puanlanmamış</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($game->requirements->count() > 0)
                                            <div class="space-y-1">
                                                @foreach($game->requirements as $req)
                                                    <div class="flex items-center space-x-2">
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $req->type === 'minimum' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                            {{ $req->type === 'minimum' ? 'Min' : 'Önerilen' }}
                                                        </span>
                                                        <span class="text-xs text-gray-600">{{ $req->ram }}GB RAM, {{ $req->disk }}GB</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">Gereksinim yok</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $game->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.games.show', $game->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors"
                                           title="Görüntüle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.games.edit', $game->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                           title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.games.destroy', $game->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Bu oyunu silmek istediğinizden emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Sil">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-gamepad text-4xl text-gray-300 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz oyun yok</h3>
                                        <p class="text-gray-500 mb-4">Başlamak için ilk oyunu ekleyin.</p>
                                        <a href="{{ route('admin.games.create') }}"
                                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                            <i class="fas fa-plus mr-2"></i>
                                            Yeni Oyun Ekle
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>

        <!-- Pagination -->
        @if($games->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $games->links() }}
            </div>
        @endif
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-gamepad text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Toplam Oyun</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalGames }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-star text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ortalama Puan</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $averageScore ? number_format($averageScore, 1) : '0.0' }}/10
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <i class="fas fa-cog text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sistem Gereksinimleri</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $gamesWithRequirements }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const gameCheckboxes = document.querySelectorAll('.game-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

    // Tümünü seç/bırak
    selectAllCheckbox.addEventListener('change', function() {
        gameCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkDeleteBtn();
    });

    // Tekil checkbox değişikliklerini dinle
    gameCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Tümünü seç checkbox'ını güncelle
            const checkedCount = document.querySelectorAll('.game-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === gameCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < gameCheckboxes.length;

            toggleBulkDeleteBtn();
        });
    });

    function toggleBulkDeleteBtn() {
        const checkedCount = document.querySelectorAll('.game-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkDeleteBtn.classList.remove('hidden');
            bulkDeleteBtn.classList.add('inline-flex');
        } else {
            bulkDeleteBtn.classList.add('hidden');
            bulkDeleteBtn.classList.remove('inline-flex');
        }
    }
});

function confirmBulkDelete() {
    const checkedCount = document.querySelectorAll('.game-checkbox:checked').length;

    if (checkedCount === 0) {
        alert('Lütfen silmek istediğiniz oyunları seçin.');
        return;
    }

    if (confirm(`Seçili ${checkedCount} oyunu silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.`)) {
        document.getElementById('bulk-delete-form').submit();
    }
}
</script>
@endpush
@endsection

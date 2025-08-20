@extends('layouts.admin')

@section('title', 'Donanım Modelleri - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Donanım Modelleri</h1>
            <p class="text-gray-600">CPU ve GPU modellerini yönetin</p>
        </div>
        <div class="flex items-center space-x-4">
            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="fas fa-shield-alt mr-1"></i>
                Sadece SuperAdmin
            </span>
            <a href="{{ route('admin.hardware.models.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Yeni Model</span>
            </a>
        </div>
    </div>

    <!-- Quick Actions & Navigation -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.hardware.brands.index') }}"
                   class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-tags mr-2"></i>
                    Markalar
                </a>
                <a href="{{ route('admin.hardware.models.index') }}"
                   class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-microchip mr-2"></i>
                    Modeller
                </a>
            </div>
            <div class="text-sm text-gray-600">
                Toplam {{ $models->total() }} model
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.hardware.models.index') }}" class="flex flex-wrap items-center gap-4">
            <!-- Brand Filter -->
            <div class="min-w-0 flex-1 max-w-xs">
                <select name="brand_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="this.form.submit()">
                    <option value="">Tüm Markalar</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Type Filter -->
            <div class="min-w-0 flex-1 max-w-xs">
                <select name="type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="this.form.submit()">
                    <option value="">Tüm Tipler</option>
                    <option value="cpu" {{ request('type') === 'cpu' ? 'selected' : '' }}>CPU</option>
                    <option value="gpu" {{ request('type') === 'gpu' ? 'selected' : '' }}>GPU</option>
                </select>
            </div>

            <!-- Search -->
            <div class="min-w-0 flex-1 max-w-xs">
                <div class="flex">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Model adı ara..."
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit"
                            class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-search text-gray-600"></i>
                    </button>
                </div>
            </div>

            @if(request()->hasAny(['brand_id', 'type', 'search']))
                <a href="{{ route('admin.hardware.models.index') }}"
                   class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-1"></i>
                    Temizle
                </a>
            @endif
        </form>
    </div>

    <!-- Models Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Model Listesi</h3>

            @if($models->count() > 0)
                <div class="flex items-center space-x-4">
                    <!-- Bulk Actions -->
                    <form id="bulk-form" method="POST" action="{{ route('admin.hardware.models.bulk-delete') }}"
                          onsubmit="return confirm('Seçilen modelleri silmek istediğinizden emin misiniz?')">
                        @csrf
                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                    id="bulk-delete-btn"
                                    disabled
                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded disabled:bg-gray-300 disabled:cursor-not-allowed">
                                <i class="fas fa-trash mr-1"></i>
                                Seçilenleri Sil
                            </button>
                        </div>
                    </form>

                    <!-- Select All -->
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" id="select-all" class="mr-2">
                        Tümünü Seç
                    </label>
                </div>
            @endif
        </div>

        @if($models->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="header-checkbox" class="text-blue-600">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Model
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Marka & Tip
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kullanım
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Oluşturulma
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İşlemler
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($models as $model)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                           name="model_ids[]"
                                           value="{{ $model->id }}"
                                           class="model-checkbox text-blue-600"
                                           form="bulk-form">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-{{ $model->type === 'cpu' ? 'microchip' : 'display' }} text-{{ $model->type === 'cpu' ? 'blue' : 'green' }}-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $model->name }}</div>
                                            @if($model->description)
                                                <div class="text-xs text-gray-500 max-w-xs truncate">{{ $model->description }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        @if($model->brand->logo)
                                            <img src="{{ $model->brand->logo }}" alt="{{ $model->brand->name }}" class="w-6 h-6 object-contain">
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $model->brand->name }}</div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                         {{ $model->type === 'cpu' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ strtoupper($model->type) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($model->total_usage > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $model->total_usage }} kullanım
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Kullanılmıyor
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $model->created_at->format('d.m.Y H:i') }}
                                    <div class="text-xs text-gray-400">
                                        {{ $model->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.hardware.models.edit', $model) }}"
                                           class="text-blue-600 hover:text-blue-900"
                                           title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if($model->total_usage == 0)
                                            <form action="{{ route('admin.hardware.models.destroy', $model) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('{{ $model->brand->name }} {{ $model->name }} modelini silmek istediğinizden emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        title="Sil">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400" title="Bu model kullanımda, silinemez">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $models->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-microchip"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    @if(request()->hasAny(['brand_id', 'type', 'search']))
                        Arama kriterlerine uygun model bulunamadı
                    @else
                        Henüz model eklenmemiş
                    @endif
                </h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['brand_id', 'type', 'search']))
                        Farklı filtreler deneyebilir veya yeni model ekleyebilirsiniz
                    @else
                        İlk donanım modelini ekleyerek başlayın
                    @endif
                </p>
                <div class="flex justify-center space-x-4">
                    @if(request()->hasAny(['brand_id', 'type', 'search']))
                        <a href="{{ route('admin.hardware.models.index') }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg inline-flex items-center space-x-2 transition-colors">
                            <i class="fas fa-times"></i>
                            <span>Filtreleri Temizle</span>
                        </a>
                    @endif
                    <a href="{{ route('admin.hardware.models.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center space-x-2 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>{{ request()->hasAny(['brand_id', 'type', 'search']) ? 'Yeni Model Ekle' : 'İlk Modeli Ekle' }}</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Bulk selection functionality
document.addEventListener('DOMContentLoaded', function() {
    const selectAllBtn = document.getElementById('select-all');
    const headerCheckbox = document.getElementById('header-checkbox');
    const modelCheckboxes = document.querySelectorAll('.model-checkbox');
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

    function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.model-checkbox:checked');
        bulkDeleteBtn.disabled = checkedBoxes.length === 0;
    }

    function updateSelectAllState() {
        const checkedBoxes = document.querySelectorAll('.model-checkbox:checked');
        const totalBoxes = modelCheckboxes.length;

        if (checkedBoxes.length === 0) {
            selectAllBtn.indeterminate = false;
            selectAllBtn.checked = false;
            headerCheckbox.indeterminate = false;
            headerCheckbox.checked = false;
        } else if (checkedBoxes.length === totalBoxes) {
            selectAllBtn.indeterminate = false;
            selectAllBtn.checked = true;
            headerCheckbox.indeterminate = false;
            headerCheckbox.checked = true;
        } else {
            selectAllBtn.indeterminate = true;
            selectAllBtn.checked = false;
            headerCheckbox.indeterminate = true;
            headerCheckbox.checked = false;
        }
    }

    selectAllBtn?.addEventListener('change', function() {
        modelCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        headerCheckbox.checked = this.checked;
        updateBulkDeleteButton();
    });

    headerCheckbox?.addEventListener('change', function() {
        modelCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        selectAllBtn.checked = this.checked;
        updateBulkDeleteButton();
    });

    modelCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkDeleteButton();
        });
    });

    // Initial state
    updateSelectAllState();
    updateBulkDeleteButton();
});
</script>
@endsection

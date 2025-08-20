@extends('layouts.admin')

@section('title', $model->brand->name . ' ' . $model->name . ' - Modeli Düzenle')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.hardware.models.index') }}"
           class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $model->brand->name }} {{ $model->name }} - Düzenle</h1>
            <p class="text-gray-600">Donanım modelini güncelleyin</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.hardware.models.update', $model) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Model Bilgileri</h3>
            </div>

            <div class="p-6 space-y-6">
                <!-- Marka Seçimi -->
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Marka <span class="text-red-500">*</span>
                    </label>
                    <select id="brand_id"
                            name="brand_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('brand_id') border-red-300 @enderror"
                            required>
                        <option value="">Marka Seçin</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $model->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tip Seçimi -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tip <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 @error('type') border-red-300 @enderror">
                            <input type="radio"
                                   name="type"
                                   value="cpu"
                                   class="text-blue-600 focus:ring-blue-500"
                                   {{ old('type', $model->type) === 'cpu' ? 'checked' : '' }}
                                   required>
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <i class="fas fa-microchip text-blue-600 mr-2"></i>
                                    <span class="text-sm font-medium text-gray-900">CPU</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">İşlemci</p>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 @error('type') border-red-300 @enderror">
                            <input type="radio"
                                   name="type"
                                   value="gpu"
                                   class="text-green-600 focus:ring-green-500"
                                   {{ old('type', $model->type) === 'gpu' ? 'checked' : '' }}
                                   required>
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <i class="fas fa-display text-green-600 mr-2"></i>
                                    <span class="text-sm font-medium text-gray-900">GPU</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Ekran Kartı</p>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model Adı -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Model Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $model->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                           placeholder="Örn: i7-12700K, RTX 4070"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Aynı marka ve tip için benzersiz olmalıdır.</p>
                </div>

                <!-- Açıklama -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Açıklama (İsteğe bağlı)
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                              placeholder="Model hakkında ek bilgiler...">{{ old('description', $model->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimum 1000 karakter. Boş bırakabilirsiniz.</p>
                </div>

                <!-- Preview -->
                <div id="model-preview" class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Önizleme</h4>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i id="preview-icon" class="fas fa-{{ $model->type === 'cpu' ? 'microchip' : 'display' }} text-{{ $model->type === 'cpu' ? 'blue' : 'green' }}-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                <span id="preview-brand">{{ $model->brand->name }}</span> <span id="preview-name">{{ $model->name }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span id="preview-type-badge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $model->type === 'cpu' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ strtoupper($model->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between rounded-b-lg">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.hardware.models.index') }}"
                       class="text-gray-600 hover:text-gray-900 px-4 py-2 text-sm font-medium">
                        İptal
                    </a>
                </div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Değişiklikleri Kaydet
                </button>
            </div>
        </form>
    </div>

    <!-- Model Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Usage Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Kullanım İstatistikleri
            </h3>

            @php
                $userSystemsCount = $model->type === 'cpu' ? $model->userSystemsCpu()->count() : $model->userSystemsGpu()->count();
                $gameRequirementsCount = $model->type === 'cpu' ? $model->gameRequirementsCpu()->count() : $model->gameRequirementsGpu()->count();
            @endphp

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Kullanıcı Sistemlerinde</span>
                    <span class="text-sm font-medium">{{ $userSystemsCount }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Oyun Gereksinimlerinde</span>
                    <span class="text-sm font-medium">{{ $gameRequirementsCount }}</span>
                </div>

                <div class="flex justify-between border-t pt-2">
                    <span class="text-sm font-medium text-gray-900">Toplam Kullanım</span>
                    <span class="text-sm font-bold">{{ $model->total_usage }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Oluşturulma Tarihi</span>
                    <span class="text-sm font-medium">{{ $model->created_at->format('d.m.Y') }}</span>
                </div>
            </div>

            @if($model->total_usage > 0)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800">
                                    Bu model {{ $model->total_usage }} yerde kullanılıyor. Silme işlemi mümkün değil.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-lightning-bolt mr-2 text-yellow-600"></i>
                Hızlı İşlemler
            </h3>

            <div class="space-y-3">
                <a href="{{ route('admin.hardware.models.create', ['brand_id' => $model->brand_id]) }}"
                   class="block w-full px-4 py-2 bg-green-100 text-green-800 text-sm rounded-lg hover:bg-green-200 transition-colors text-center">
                    <i class="fas fa-plus mr-2"></i>
                    {{ $model->brand->name }} Markasına Model Ekle
                </a>

                <a href="{{ route('admin.hardware.brands.edit', $model->brand) }}"
                   class="block w-full px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-lg hover:bg-blue-200 transition-colors text-center">
                    <i class="fas fa-edit mr-2"></i>
                    {{ $model->brand->name }} Markasını Düzenle
                </a>

                <a href="{{ route('admin.hardware.models.index', ['type' => $model->type]) }}"
                   class="block w-full px-4 py-2 bg-purple-100 text-purple-800 text-sm rounded-lg hover:bg-purple-200 transition-colors text-center">
                    <i class="fas fa-{{ $model->type === 'cpu' ? 'microchip' : 'display' }} mr-2"></i>
                    Diğer {{ strtoupper($model->type) }} Modelleri
                </a>

                @if($model->total_usage == 0)
                    <form action="{{ route('admin.hardware.models.destroy', $model) }}"
                          method="POST"
                          onsubmit="return confirm('{{ $model->brand->name }} {{ $model->name }} modelini silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="block w-full px-4 py-2 bg-red-100 text-red-800 text-sm rounded-lg hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Modeli Sil
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('brand_id');
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const nameInput = document.getElementById('name');
    const previewBrand = document.getElementById('preview-brand');
    const previewName = document.getElementById('preview-name');
    const previewIcon = document.getElementById('preview-icon');
    const previewTypeBadge = document.getElementById('preview-type-badge');

    function updatePreview() {
        const selectedBrand = brandSelect.options[brandSelect.selectedIndex];
        const selectedType = document.querySelector('input[name="type"]:checked');
        const name = nameInput.value;

        if (selectedBrand.value && selectedType && name) {
            previewBrand.textContent = selectedBrand.textContent;
            previewName.textContent = name;

            if (selectedType.value === 'cpu') {
                previewIcon.className = 'fas fa-microchip text-blue-600';
                previewTypeBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                previewTypeBadge.textContent = 'CPU';
            } else {
                previewIcon.className = 'fas fa-display text-green-600';
                previewTypeBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                previewTypeBadge.textContent = 'GPU';
            }
        }
    }

    brandSelect.addEventListener('change', updatePreview);
    typeRadios.forEach(radio => radio.addEventListener('change', updatePreview));
    nameInput.addEventListener('input', updatePreview);
});
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Yeni Donanım Modeli - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.hardware.models.index') }}"
           class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Yeni Donanım Modeli</h1>
            <p class="text-gray-600">CPU veya GPU modeli ekleyin</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.hardware.models.store') }}" method="POST">
            @csrf

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
                            <option value="{{ $brand->id }}" {{ old('brand_id', request('brand_id')) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @if($brands->count() == 0)
                        <div class="mt-2 p-3 bg-yellow-50 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-800">
                                        Henüz marka eklenmemiş.
                                        <a href="{{ route('admin.hardware.brands.create') }}" class="font-medium underline">
                                            Önce bir marka ekleyin
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                   {{ old('type') === 'cpu' ? 'checked' : '' }}
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
                                   {{ old('type') === 'gpu' ? 'checked' : '' }}
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
                           value="{{ old('name') }}"
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
                              placeholder="Model hakkında ek bilgiler...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimum 1000 karakter. Boş bırakabilirsiniz.</p>
                </div>

                <!-- Preview -->
                <div id="model-preview" class="hidden bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Önizleme</h4>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i id="preview-icon" class="fas fa-microchip text-blue-600"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                                <span id="preview-brand">Marka</span> <span id="preview-name">Model</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span id="preview-type-badge" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    CPU
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
                    Modeli Kaydet
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Popular Models Info -->
        <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Popüler CPU Modelleri</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Intel: i3-12100F, i5-12400F, i7-12700K</li>
                            <li>AMD: Ryzen 5 5600, Ryzen 7 5700X</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-green-50 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightning-bolt text-green-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Hızlı İşlemler</h3>
                    <div class="mt-2 space-y-2">
                        <a href="{{ route('admin.hardware.brands.create') }}"
                           class="block text-sm text-green-700 hover:text-green-900">
                            → Yeni marka ekle
                        </a>
                        <a href="{{ route('admin.hardware.brands.index') }}"
                           class="block text-sm text-green-700 hover:text-green-900">
                            → Markaları yönet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('brand_id');
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const nameInput = document.getElementById('name');
    const preview = document.getElementById('model-preview');
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

            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }

    brandSelect.addEventListener('change', updatePreview);
    typeRadios.forEach(radio => radio.addEventListener('change', updatePreview));
    nameInput.addEventListener('input', updatePreview);

    // Initial preview update
    updatePreview();
});
</script>
@endsection

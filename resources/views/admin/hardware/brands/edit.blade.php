@extends('layouts.admin')

@section('title', $brand->name . ' - Markayı Düzenle')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.hardware.brands.index') }}"
           class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $brand->name }} - Düzenle</h1>
            <p class="text-gray-600">Donanım markasını güncelleyin</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.hardware.brands.update', $brand) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Marka Bilgileri</h3>
            </div>

            <div class="p-6 space-y-6">
                <!-- Marka Adı -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Marka Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $brand->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-300 @enderror"
                           placeholder="Örn: Intel, AMD, Nvidia"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Marka adı benzersiz olmalıdır.</p>
                </div>

                <!-- Logo URL -->
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo URL (İsteğe bağlı)
                    </label>
                    <input type="url"
                           id="logo"
                           name="logo"
                           value="{{ old('logo', $brand->logo) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('logo') border-red-300 @enderror"
                           placeholder="https://example.com/logo.png">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Markanın logo URL'si. Boş bırakabilirsiniz.</p>
                </div>

                <!-- Current Logo & Preview -->
                <div class="flex space-x-6">
                    @if($brand->logo)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mevcut Logo</label>
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-gray-300">
                                <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="w-12 h-12 object-contain">
                            </div>
                        </div>
                    @endif

                    <div id="logo-preview" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Yeni Logo Önizleme</label>
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                            <img id="preview-image" src="" alt="Logo" class="w-12 h-12 object-contain">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between rounded-b-lg">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.hardware.brands.index') }}"
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

    <!-- Brand Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Marka İstatistikleri
            </h3>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Toplam Model Sayısı</span>
                    <span class="text-sm font-medium">{{ $brand->models()->count() }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">CPU Model Sayısı</span>
                    <span class="text-sm font-medium">{{ $brand->models()->where('type', 'cpu')->count() }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">GPU Model Sayısı</span>
                    <span class="text-sm font-medium">{{ $brand->models()->where('type', 'gpu')->count() }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Oluşturulma Tarihi</span>
                    <span class="text-sm font-medium">{{ $brand->created_at->format('d.m.Y') }}</span>
                </div>
            </div>

            @if($brand->models()->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.hardware.models.index', ['brand' => $brand->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-lg hover:bg-blue-200 transition-colors">
                        <i class="fas fa-microchip mr-2"></i>
                        Modelleri Görüntüle
                    </a>
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
                <a href="{{ route('admin.hardware.models.create', ['brand_id' => $brand->id]) }}"
                   class="block w-full px-4 py-2 bg-green-100 text-green-800 text-sm rounded-lg hover:bg-green-200 transition-colors text-center">
                    <i class="fas fa-plus mr-2"></i>
                    Bu Markaya Model Ekle
                </a>

                <a href="{{ route('admin.hardware.brands.create') }}"
                   class="block w-full px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-lg hover:bg-blue-200 transition-colors text-center">
                    <i class="fas fa-tag mr-2"></i>
                    Yeni Marka Ekle
                </a>

                @if($brand->models()->count() == 0)
                    <form action="{{ route('admin.hardware.brands.destroy', $brand) }}"
                          method="POST"
                          onsubmit="return confirm('{{ $brand->name }} markasını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="block w-full px-4 py-2 bg-red-100 text-red-800 text-sm rounded-lg hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Markayı Sil
                        </button>
                    </form>
                @else
                    <div class="text-center p-2 bg-gray-100 text-gray-600 text-sm rounded-lg">
                        <i class="fas fa-info-circle mr-2"></i>
                        Bu markaya ait modeller var, silinemez
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('logo').addEventListener('input', function() {
    const logoUrl = this.value;
    const preview = document.getElementById('logo-preview');
    const previewImage = document.getElementById('preview-image');
    const currentValue = '{{ $brand->logo }}';

    if (logoUrl && logoUrl !== currentValue && logoUrl.match(/\.(jpeg|jpg|gif|png|svg)$/)) {
        previewImage.src = logoUrl;
        preview.classList.remove('hidden');

        previewImage.onerror = function() {
            preview.classList.add('hidden');
        };
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Yeni Donanım Markası - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.hardware.brands.index') }}"
           class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Yeni Donanım Markası</h1>
            <p class="text-gray-600">CPU veya GPU markası ekleyin</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.hardware.brands.store') }}" method="POST">
            @csrf

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
                           value="{{ old('name') }}"
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
                           value="{{ old('logo') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('logo') border-red-300 @enderror"
                           placeholder="https://example.com/logo.png">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Markanın logo URL'si. Boş bırakabilirsiniz.</p>
                </div>

                <!-- Preview -->
                <div id="logo-preview" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo Önizleme</label>
                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                        <img id="preview-image" src="" alt="Logo" class="w-12 h-12 object-contain">
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
                    Markayı Kaydet
                </button>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Bilgi</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Marka adı CPU ve GPU için ortak kullanılır (Intel, AMD, Nvidia vb.)</li>
                        <li>Logo URL'si isteğe bağlıdır, boş bırakabilirsiniz</li>
                        <li>Markayı sildikten sonra, bu markaya ait tüm modeller de silinir</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('logo').addEventListener('input', function() {
    const logoUrl = this.value;
    const preview = document.getElementById('logo-preview');
    const previewImage = document.getElementById('preview-image');

    if (logoUrl && logoUrl.match(/\.(jpeg|jpg|gif|png|svg)$/)) {
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

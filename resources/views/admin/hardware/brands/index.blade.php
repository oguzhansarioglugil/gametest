@extends('layouts.admin')

@section('title', 'Donanım Markaları - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Donanım Markaları</h1>
            <p class="text-gray-600">CPU ve GPU markalarını yönetin</p>
        </div>
        <div class="flex items-center space-x-4">
            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="fas fa-shield-alt mr-1"></i>
                Sadece SuperAdmin
            </span>
            <a href="{{ route('admin.hardware.brands.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Yeni Marka</span>
            </a>
        </div>
    </div>

    <!-- Quick Actions & Navigation -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.hardware.brands.index') }}"
                   class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium">
                    <i class="fas fa-tags mr-2"></i>
                    Markalar
                </a>
                <a href="{{ route('admin.hardware.models.index') }}"
                   class="text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-microchip mr-2"></i>
                    Modeller
                </a>
            </div>
            <div class="text-sm text-gray-600">
                Toplam {{ $brands->total() }} marka
            </div>
        </div>
    </div>

    <!-- Brands List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Marka Listesi</h3>
        </div>

        @if($brands->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Marka
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Model Sayısı
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
                        @foreach($brands as $brand)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($brand->logo)
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                                <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="w-8 h-8 object-contain">
                                            </div>
                                        @else
                                            <div class="w-10 h-10 bg-gray-300 rounded-lg flex items-center justify-center mr-4">
                                                <i class="fas fa-tag text-gray-600"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $brand->name }}</div>
                                            @if($brand->logo)
                                                <div class="text-xs text-gray-500">Logo var</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $brand->models_count }} model
                                        </span>
                                        @if($brand->models_count > 0)
                                            <a href="{{ route('admin.hardware.models.index', ['brand' => $brand->id]) }}"
                                               class="text-blue-600 hover:text-blue-900 text-xs">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $brand->created_at->format('d.m.Y H:i') }}
                                    <div class="text-xs text-gray-400">
                                        {{ $brand->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.hardware.brands.edit', $brand) }}"
                                           class="text-blue-600 hover:text-blue-900"
                                           title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if($brand->models_count == 0)
                                            <form action="{{ route('admin.hardware.brands.destroy', $brand) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirm('{{ $brand->name }} markasını silmek istediğinizden emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        title="Sil">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400" title="Bu markaya ait modeller var, silinemez">
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
                {{ $brands->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz marka eklenmemiş</h3>
                <p class="text-gray-600 mb-6">İlk donanım markasını ekleyerek başlayın</p>
                <a href="{{ route('admin.hardware.brands.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>İlk Markayı Ekle</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

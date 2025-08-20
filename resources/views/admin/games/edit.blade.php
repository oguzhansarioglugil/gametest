@extends('layouts.admin')

@section('title', $game->name . ' - Düzenle')
@section('page-title', $game->name . ' - Düzenle')
@section('page-description', 'Oyun bilgilerini güncelleyin')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('admin.games.index') }}" class="text-gray-700 hover:text-blue-600">Oyun Yönetimi</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('admin.games.show', $game->id) }}" class="text-gray-700 hover:text-blue-600">{{ $game->name }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-gray-500">Düzenle</span>
                </div>
            </li>
        </ol>
    </nav>

    <form action="{{ route('admin.games.update', $game->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">
                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                Temel Bilgiler
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Game Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Oyun Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $game->name) }}"
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Score -->
                <div>
                    <label for="score" class="block text-sm font-medium text-gray-700 mb-2">
                        Puan (1-10)
                    </label>
                    <input type="number"
                           id="score"
                           name="score"
                           value="{{ old('score', $game->score) }}"
                           min="1"
                           max="10"
                           step="0.1"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('score') border-red-500 @enderror">
                    @error('score')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Açıklama <span class="text-red-500">*</span>
                </label>
                <textarea id="description"
                          name="description"
                          rows="4"
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $game->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($game->image)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mevcut Resim</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-20 h-20 object-cover rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600">{{ $game->image }}</p>
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-red-600">Bu resmi sil</span>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <!-- New Image -->
            <div class="mt-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $game->image ? 'Yeni Resim' : 'Oyun Resmi' }}
                </label>
                <div class="flex items-center space-x-4">
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('image') border-red-500 @enderror">
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">PNG, JPG veya JPEG formatında maksimum 2MB</p>
            </div>
        </div>

        <!-- System Requirements -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-cogs mr-2 text-green-600"></i>
                    Sistem Gereksinimleri
                </h3>
                <button type="button"
                        id="add-requirement"
                        class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Gereksinim Ekle
                </button>
            </div>

            <div id="requirements-container" class="space-y-6">
                <!-- Existing requirements will be loaded here -->
                @foreach($game->requirements as $index => $requirement)
                    <div class="border border-gray-200 rounded-lg p-6 relative existing-requirement">
                        <button type="button" class="absolute top-4 right-4 text-red-600 hover:text-red-800 remove-requirement">
                            <i class="fas fa-times"></i>
                        </button>

                        <input type="hidden" name="requirements[{{ $index }}][id]" value="{{ $requirement->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tip</label>
                                <select name="requirements[{{ $index }}][type]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="minimum" {{ $requirement->type === 'minimum' ? 'selected' : '' }}>Minimum</option>
                                    <option value="recommended" {{ $requirement->type === 'recommended' ? 'selected' : '' }}>Önerilen</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">RAM (GB)</label>
                                <input type="number" name="requirements[{{ $index }}][ram]" value="{{ $requirement->ram }}" min="1" max="128" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disk Alanı (GB)</label>
                                <input type="number" name="requirements[{{ $index }}][disk]" value="{{ $requirement->disk }}" min="1" max="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- CPU Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">İşlemci (CPU)</label>
                                <div class="cpu-selection space-y-2">
                                    @foreach($requirement->cpus as $cpu)
                                        <div class="flex items-center space-x-2">
                                            <input type="hidden" name="requirements[{{ $index }}][existing_cpus][]" value="{{ $cpu->id }}">
                                            <input type="text" value="{{ $cpu->name }}" readonly class="flex-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                                            <button type="button" class="text-red-600 hover:text-red-800 remove-existing-cpu" data-cpu-id="{{ $cpu->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    <button type="button" class="add-cpu-btn w-full px-3 py-2 border-2 border-dashed border-gray-300 text-gray-600 rounded-lg hover:border-blue-500 hover:text-blue-600">
                                        <i class="fas fa-plus mr-2"></i>
                                        CPU Ekle
                                    </button>
                                </div>
                            </div>

                            <!-- GPU Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ekran Kartı (GPU)</label>
                                <div class="gpu-selection space-y-2">
                                    @foreach($requirement->gpus as $gpu)
                                        <div class="flex items-center space-x-2">
                                            <input type="hidden" name="requirements[{{ $index }}][existing_gpus][]" value="{{ $gpu->id }}">
                                            <input type="text" value="{{ $gpu->name }}" readonly class="flex-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                                            <button type="button" class="text-red-600 hover:text-red-800 remove-existing-gpu" data-gpu-id="{{ $gpu->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                    <button type="button" class="add-gpu-btn w-full px-3 py-2 border-2 border-dashed border-gray-300 text-gray-600 rounded-lg hover:border-green-500 hover:text-green-600">
                                        <i class="fas fa-plus mr-2"></i>
                                        GPU Ekle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
            <a href="{{ route('admin.games.show', $game->id) }}"
               class="inline-flex items-center justify-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-times mr-2"></i>
                İptal
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i>
                Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let requirementIndex = {{ $game->requirements->count() }};
    const container = document.getElementById('requirements-container');
    const addButton = document.getElementById('add-requirement');

    addButton.addEventListener('click', function() {
        addRequirement();
    });

    // Handle existing requirements
    document.querySelectorAll('.existing-requirement').forEach(function(reqDiv) {
        setupRequirementEvents(reqDiv);
    });

    function setupRequirementEvents(requirementDiv) {
        // Remove requirement
        requirementDiv.querySelector('.remove-requirement').addEventListener('click', function() {
            requirementDiv.remove();
        });

        // Remove existing CPUs
        requirementDiv.querySelectorAll('.remove-existing-cpu').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const cpuId = this.dataset.cpuId;
                // Add to removal list
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_cpus[]';
                hiddenInput.value = cpuId;
                requirementDiv.appendChild(hiddenInput);
                this.parentElement.remove();
            });
        });

        // Remove existing GPUs
        requirementDiv.querySelectorAll('.remove-existing-gpu').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const gpuId = this.dataset.gpuId;
                // Add to removal list
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_gpus[]';
                hiddenInput.value = gpuId;
                requirementDiv.appendChild(hiddenInput);
                this.parentElement.remove();
            });
        });

        // Add new CPUs/GPUs
        setupAddButtons(requirementDiv);
    }

    function setupAddButtons(requirementDiv) {
        const reqIndex = Array.from(container.children).indexOf(requirementDiv);

        requirementDiv.querySelector('.add-cpu-btn').addEventListener('click', function() {
            const cpuDiv = document.createElement('div');
            cpuDiv.className = 'flex items-center space-x-2 mb-2';
            cpuDiv.innerHTML = `
                <div class="flex-1 relative">
                    <input type="text" class="cpu-search w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="CPU Ara... (örn: i5-14600K)">
                    <input type="hidden" name="requirements[${reqIndex}][cpus][]" class="cpu-id-input">
                    <div class="cpu-dropdown absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-lg shadow-lg z-10 hidden max-h-48 overflow-y-auto"></div>
                </div>
                <button type="button" class="text-red-600 hover:text-red-800 remove-cpu">
                    <i class="fas fa-times"></i>
                </button>
            `;
            requirementDiv.querySelector('.cpu-selection').insertBefore(cpuDiv, this);

            // Setup CPU autocomplete
            setupCpuAutocomplete(cpuDiv.querySelector('.cpu-search'));

            cpuDiv.querySelector('.remove-cpu').addEventListener('click', function() {
                cpuDiv.remove();
            });
        });

        requirementDiv.querySelector('.add-gpu-btn').addEventListener('click', function() {
            const gpuDiv = document.createElement('div');
            gpuDiv.className = 'flex items-center space-x-2 mb-2';
            gpuDiv.innerHTML = `
                <div class="flex-1 relative">
                    <input type="text" class="gpu-search w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="GPU Ara... (örn: RTX 5070)">
                    <input type="hidden" name="requirements[${reqIndex}][gpus][]" class="gpu-id-input">
                    <div class="gpu-dropdown absolute top-full left-0 right-0 bg-white border border-gray-300 rounded-lg shadow-lg z-10 hidden max-h-48 overflow-y-auto"></div>
                </div>
                <button type="button" class="text-red-600 hover:text-red-800 remove-gpu">
                    <i class="fas fa-times"></i>
                </button>
            `;
            requirementDiv.querySelector('.gpu-selection').insertBefore(gpuDiv, this);

            // Setup GPU autocomplete
            setupGpuAutocomplete(gpuDiv.querySelector('.gpu-search'));

            gpuDiv.querySelector('.remove-gpu').addEventListener('click', function() {
                gpuDiv.remove();
            });
        });
    }

    function addRequirement() {
        const requirementDiv = document.createElement('div');
        requirementDiv.className = 'border border-gray-200 rounded-lg p-6 relative';
        requirementDiv.innerHTML = `
            <button type="button" class="absolute top-4 right-4 text-red-600 hover:text-red-800 remove-requirement">
                <i class="fas fa-times"></i>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tip</label>
                    <select name="requirements[${requirementIndex}][type]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="minimum">Minimum</option>
                        <option value="recommended">Önerilen</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">RAM (GB)</label>
                    <input type="number" name="requirements[${requirementIndex}][ram]" min="1" max="128" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disk Alanı (GB)</label>
                    <input type="number" name="requirements[${requirementIndex}][disk]" min="1" max="1000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">İşlemci (CPU)</label>
                    <div class="cpu-selection space-y-2">
                        <button type="button" class="add-cpu-btn w-full px-3 py-2 border-2 border-dashed border-gray-300 text-gray-600 rounded-lg hover:border-blue-500 hover:text-blue-600">
                            <i class="fas fa-plus mr-2"></i>
                            CPU Ekle
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ekran Kartı (GPU)</label>
                    <div class="gpu-selection space-y-2">
                        <button type="button" class="add-gpu-btn w-full px-3 py-2 border-2 border-dashed border-gray-300 text-gray-600 rounded-lg hover:border-green-500 hover:text-green-600">
                            <i class="fas fa-plus mr-2"></i>
                            GPU Ekle
                        </button>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(requirementDiv);
        setupRequirementEvents(requirementDiv);
        requirementIndex++;
    }

    // CPU Autocomplete Setup
    function setupCpuAutocomplete(inputElement) {
        const dropdown = inputElement.parentElement.querySelector('.cpu-dropdown');
        const hiddenInput = inputElement.parentElement.querySelector('.cpu-id-input');
        let searchTimeout;

        inputElement.addEventListener('input', function() {
            const query = this.value.trim();

            clearTimeout(searchTimeout);

            if (query.length < 2) {
                dropdown.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.api.search.cpus') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        dropdown.innerHTML = '';

                        if (data.length === 0) {
                            dropdown.innerHTML = '<div class="px-3 py-2 text-gray-500 text-sm">Sonuç bulunamadı</div>';
                        } else {
                            data.forEach(cpu => {
                                const option = document.createElement('div');
                                option.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0';
                                option.innerHTML = `
                                    <div class="font-medium text-gray-900">${cpu.full_name}</div>
                                    ${cpu.benchmark_score ? `<div class="text-sm text-gray-500">Benchmark: ${cpu.benchmark_score} puan</div>` : ''}
                                `;

                                option.addEventListener('click', function() {
                                    inputElement.value = cpu.full_name;
                                    hiddenInput.value = cpu.id;
                                    dropdown.classList.add('hidden');
                                });

                                dropdown.appendChild(option);
                            });
                        }

                        dropdown.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('CPU arama hatası:', error);
                        dropdown.innerHTML = '<div class="px-3 py-2 text-red-500 text-sm">Arama sırasında hata oluştu</div>';
                        dropdown.classList.remove('hidden');
                    });
            }, 300);
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!inputElement.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }

    // GPU Autocomplete Setup
    function setupGpuAutocomplete(inputElement) {
        const dropdown = inputElement.parentElement.querySelector('.gpu-dropdown');
        const hiddenInput = inputElement.parentElement.querySelector('.gpu-id-input');
        let searchTimeout;

        inputElement.addEventListener('input', function() {
            const query = this.value.trim();

            clearTimeout(searchTimeout);

            if (query.length < 2) {
                dropdown.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('admin.api.search.gpus') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        dropdown.innerHTML = '';

                        if (data.length === 0) {
                            dropdown.innerHTML = '<div class="px-3 py-2 text-gray-500 text-sm">Sonuç bulunamadı</div>';
                        } else {
                            data.forEach(gpu => {
                                const option = document.createElement('div');
                                option.className = 'px-3 py-2 hover:bg-green-50 cursor-pointer border-b border-gray-100 last:border-b-0';
                                option.innerHTML = `
                                    <div class="font-medium text-gray-900">${gpu.full_name}</div>
                                    ${gpu.benchmark_score ? `<div class="text-sm text-gray-500">Benchmark: ${gpu.benchmark_score} puan</div>` : ''}
                                `;

                                option.addEventListener('click', function() {
                                    inputElement.value = gpu.full_name;
                                    hiddenInput.value = gpu.id;
                                    dropdown.classList.add('hidden');
                                });

                                dropdown.appendChild(option);
                            });
                        }

                        dropdown.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('GPU arama hatası:', error);
                        dropdown.innerHTML = '<div class="px-3 py-2 text-red-500 text-sm">Arama sırasında hata oluştu</div>';
                        dropdown.classList.remove('hidden');
                    });
            }, 300);
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!inputElement.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush
@endsection

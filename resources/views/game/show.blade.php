@extends('layouts.app')

@section('title', $game->name . ' - GameTest')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-purple-600 transition-colors">
                <i class="fas fa-home"></i>
                <span class="ml-1">Anasayfa</span>
            </a>
            <i class="fas fa-chevron-right text-gray-400"></i>
            <span class="text-gray-800 font-medium">{{ $game->name }}</span>
        </nav>
    </div>
</div>

<!-- Oyun Detayları -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Sol Taraf - Oyun Bilgileri -->
            <div class="lg:col-span-2">
                <!-- Oyun Başlığı ve Puan -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $game->name }}</h1>

                    @if($game->score)
                        <div class="flex items-center mb-4">
                            <div class="flex items-center space-x-1 mr-4">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($game->score / 2))
                                        <i class="fas fa-star text-yellow-400 text-xl"></i>
                                    @elseif($i == ceil($game->score / 2) && $game->score % 2 != 0)
                                        <i class="fas fa-star-half-alt text-yellow-400 text-xl"></i>
                                    @else
                                        <i class="far fa-star text-gray-300 text-xl"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-2xl font-bold text-gray-800">{{ $game->score }}/10</span>
                            <span class="ml-2 text-gray-600">Puan</span>
                        </div>
                    @endif
                </div>

                <!-- Oyun Açıklaması -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-purple-600 mr-3"></i>
                        Oyun Hakkında
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-lg">{{ $game->description }}</p>
                </div>

                <!-- Sistem Gereksinimleri -->
                <div class="space-y-8">
                    <!-- Minimum Gereksinimler -->
                    @if($game->minimumRequirements)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="bg-red-50 px-8 py-4 border-b border-red-100">
                                <h3 class="text-xl font-bold text-red-800 flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                                    Minimum Sistem Gereksinimleri
                                </h3>
                                <p class="text-red-600 text-sm mt-1">Oyunu çalıştırmak için gereken en düşük donanım</p>
                            </div>
                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- CPU Seçenekleri -->
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-microchip text-blue-500 mr-2"></i>
                                            İşlemci (CPU)
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($game->minimumRequirements->cpus as $cpu)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-microchip text-blue-600 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800">{{ $cpu->brand->name }}</div>
                                                        <div class="text-sm text-gray-600">{{ $cpu->name }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- GPU Seçenekleri -->
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-tv text-green-500 mr-2"></i>
                                            Ekran Kartı (GPU)
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($game->minimumRequirements->gpus as $gpu)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-tv text-green-600 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800">{{ $gpu->brand->name }}</div>
                                                        <div class="text-sm text-gray-600">{{ $gpu->name }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- RAM ve Disk -->
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-memory text-purple-500 mr-2"></i>
                                            Bellek (RAM)
                                        </h4>
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-memory text-purple-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $game->minimumRequirements->ram ?? 'N/A' }} GB</div>
                                                <div class="text-sm text-gray-600">Sistem Belleği</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-hdd text-orange-500 mr-2"></i>
                                            Depolama Alanı
                                        </h4>
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-hdd text-orange-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $game->minimumRequirements->disk ?? 'N/A' }} GB</div>
                                                <div class="text-sm text-gray-600">Boş Disk Alanı</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Önerilen Gereksinimler -->
                    @if($game->recommendedRequirements)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="bg-green-50 px-8 py-4 border-b border-green-100">
                                <h3 class="text-xl font-bold text-green-800 flex items-center">
                                    <i class="fas fa-star text-green-600 mr-3"></i>
                                    Önerilen Sistem Gereksinimleri
                                </h3>
                                <p class="text-green-600 text-sm mt-1">En iyi oyun deneyimi için önerilen donanım</p>
                            </div>
                            <div class="p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- CPU Seçenekleri -->
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-microchip text-blue-500 mr-2"></i>
                                            İşlemci (CPU)
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($game->recommendedRequirements->cpus as $cpu)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-microchip text-blue-600 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800">{{ $cpu->brand->name }}</div>
                                                        <div class="text-sm text-gray-600">{{ $cpu->name }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- GPU Seçenekleri -->
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-tv text-green-500 mr-2"></i>
                                            Ekran Kartı (GPU)
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach($game->recommendedRequirements->gpus as $gpu)
                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                        <i class="fas fa-tv text-green-600 text-sm"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-800">{{ $gpu->brand->name }}</div>
                                                        <div class="text-sm text-gray-600">{{ $gpu->name }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- RAM ve Disk -->
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-memory text-purple-500 mr-2"></i>
                                            Bellek (RAM)
                                        </h4>
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-memory text-purple-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $game->recommendedRequirements->ram ?? 'N/A' }} GB</div>
                                                <div class="text-sm text-gray-600">Sistem Belleği</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                                            <i class="fas fa-hdd text-orange-500 mr-2"></i>
                                            Depolama Alanı
                                        </h4>
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-hdd text-orange-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $game->recommendedRequirements->disk ?? 'N/A' }} GB</div>
                                                <div class="text-sm text-gray-600">Boş Disk Alanı</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sağ Taraf - Oyun Resmi ve Hızlı Bilgiler -->
            <div class="lg:col-span-1">
                <!-- Oyun Resmi -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <div class="h-64 bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center">
                        @if($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-white text-center">
                                <i class="fas fa-gamepad text-6xl mb-4"></i>
                                <p class="text-lg font-medium">{{ $game->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Hızlı Bilgiler -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Hızlı Bilgiler</h3>
                    <div class="space-y-4">
                        @if($game->score)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Puan:</span>
                                <span class="font-semibold text-gray-800">{{ $game->score }}/10</span>
                            </div>
                        @endif

                        @if($game->minimumRequirements)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Min. RAM:</span>
                                <span class="font-semibold text-gray-800">{{ $game->minimumRequirements->ram ?? 'N/A' }} GB</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Disk Alanı:</span>
                                <span class="font-semibold text-gray-800">{{ $game->minimumRequirements->disk ?? 'N/A' }} GB</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">CPU Seçenekleri:</span>
                                <span class="font-semibold text-gray-800">{{ $game->minimumRequirements->cpus->count() }} adet</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">GPU Seçenekleri:</span>
                                <span class="font-semibold text-gray-800">{{ $game->minimumRequirements->gpus->count() }} adet</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sistem Test Butonu -->
                <button id="systemTestBtn" onclick="testGameCompatibility({{ $game->id }})"
                       class="block w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-center py-3 rounded-lg font-semibold transition-all duration-200 mb-4 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-desktop mr-2"></i>
                    <span id="testBtnText">Sistemi Test Et</span>
                </button>

                <div id="testResults" class="hidden mb-4"></div>

                <!-- Geri Dön Butonu -->
                <a href="{{ route('home') }}"
                   class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Anasayfaya Dön
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Eski localStorage verilerini temizle
localStorage.removeItem('system_hardware');

// Kullanıcı durumunu PHP'den JavaScript'e aktar
window.userStatus = {!! json_encode([
    'isAuthenticated' => auth()->check(),
    'hasSystemInfo' => auth()->check() && auth()->user()->userSystem,
    'systemInfo' => auth()->check() && auth()->user()->userSystem ? [
        'cpu_name' => auth()->user()->userSystem->cpu->name ?? 'Unknown CPU',
        'gpu_name' => auth()->user()->userSystem->gpu->name ?? 'Unknown GPU',
        'ram_gb' => auth()->user()->userSystem->ram,
        'disk_free_gb' => auth()->user()->userSystem->disk,
        'os' => 'User System'
    ] : null
]) !!};

function testGameCompatibility(gameId) {
    // Kullanıcının giriş yapıp yapmadığını kontrol et
    if (!userStatus.isAuthenticated) {
        showTestResult('warning', 'Giriş yapmalısınız!', 'Sistem testi için lütfen önce giriş yapın.');
        return;
    }

    // Kullanıcının sistem bilgilerini kontrol et
    if (!userStatus.hasSystemInfo) {
        showTestResult('info', 'Sistem bilgileri eksik!', 'Lütfen profil sayfanızdan sistem bilgilerinizi girin.');
        setTimeout(() => {
            window.location.href = '{{ route("profile.index") }}#system';
        }, 2000);
        return;
    }

    // Sistem bilgilerini al
    const systemInfo = userStatus.systemInfo;

    // Buton durumunu değiştir
    const btn = document.getElementById('systemTestBtn');
    const btnText = document.getElementById('testBtnText');
    btn.disabled = true;
    btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Test Ediliyor...';

    // API'ye tek oyun testi gönder
    fetch('/api/test-single-game', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            game_id: gameId,
            ...systemInfo
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayGameTestResult(data.data);
        } else {
            showTestResult('error', 'Test Başarısız!', data.message || 'Bir hata oluştu.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showTestResult('error', 'Bağlantı Hatası!', 'Sunucuya bağlanırken bir hata oluştu.');
    })
    .finally(() => {
        // Buton durumunu geri getir
        btn.disabled = false;
        btnText.innerHTML = 'Sistemi Test Et';
    });
}

function displayGameTestResult(result) {
    const compatibility = result.compatibility;
    const percentage = result.percentage;
    const details = result.details;
    const userSystem = userStatus.systemInfo; // Kullanıcının sistem bilgileri

    let statusColor, statusIcon, statusText;

    switch (compatibility) {
        case 'excellent':
            statusColor = 'green';
            statusIcon = 'fas fa-check-circle';
            statusText = 'Mükemmel';
            break;
        case 'good':
            statusColor = 'blue';
            statusIcon = 'fas fa-thumbs-up';
            statusText = 'İyi';
            break;
        case 'fair':
            statusColor = 'yellow';
            statusIcon = 'fas fa-exclamation-triangle';
            statusText = 'Orta';
            break;
        case 'poor':
            statusColor = 'red';
            statusIcon = 'fas fa-times-circle';
            statusText = 'Zayıf';
            break;
        default:
            statusColor = 'gray';
            statusIcon = 'fas fa-question-circle';
            statusText = 'Bilinmiyor';
    }

    let detailsHtml = '';
    Object.keys(details).forEach(level => {
        const detail = details[level];
        detailsHtml += `
            <div class="mb-3">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-medium text-gray-700 capitalize">${level} Gereksinimler:</span>
                    <span class="text-sm font-bold text-${statusColor}-600">${detail.percentage.toFixed(1)}%</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-microchip mr-1 ${detail.cpu_ok ? 'text-green-500' : 'text-red-500'}"></i>
                        <span class="${detail.cpu_ok ? 'text-green-700' : 'text-red-700'}">CPU ${detail.cpu_ok ? '✓' : '✗'}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tv mr-1 ${detail.gpu_ok ? 'text-green-500' : 'text-red-500'}"></i>
                        <span class="${detail.gpu_ok ? 'text-green-700' : 'text-red-700'}">GPU ${detail.gpu_ok ? '✓' : '✗'}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-memory mr-1 ${detail.ram_ok ? 'text-green-500' : 'text-red-500'}"></i>
                        <span class="${detail.ram_ok ? 'text-green-700' : 'text-red-700'}">RAM ${detail.ram_ok ? '✓' : '✗'}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-hdd mr-1 ${detail.disk_ok ? 'text-green-500' : 'text-red-500'}"></i>
                        <span class="${detail.disk_ok ? 'text-green-700' : 'text-red-700'}">Disk ${detail.disk_ok ? '✓' : '✗'}</span>
                    </div>
                </div>
            </div>
        `;
    });

    const resultHtml = `
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                    <i class="${statusIcon} text-${statusColor}-500 text-xl mr-2"></i>
                    <span class="font-bold text-lg text-gray-800">${statusText} Uyumluluk</span>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-${statusColor}-600">${percentage}%</div>
                    <div class="text-sm text-gray-500">Uyumluluk</div>
                </div>
            </div>
            <div class="mb-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-${statusColor}-500 h-2 rounded-full transition-all duration-300" style="width: ${percentage}%"></div>
                </div>
            </div>

            <!-- Kullanıcının Sistem Bilgileri -->
            <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                <h4 class="font-medium text-blue-800 mb-2 flex items-center">
                    <i class="fas fa-desktop mr-2"></i>
                    Sizin Sisteminiz:
                </h4>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-microchip mr-1 text-blue-500"></i>
                        <span class="text-blue-700">${userSystem.cpu_name}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tv mr-1 text-blue-500"></i>
                        <span class="text-blue-700">${userSystem.gpu_name}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-memory mr-1 text-blue-500"></i>
                        <span class="text-blue-700">${userSystem.ram_gb} GB RAM</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-hdd mr-1 text-blue-500"></i>
                        <span class="text-blue-700">${userSystem.disk_free_gb} GB Disk</span>
                    </div>
                </div>
            </div>

            ${detailsHtml}
            ${result.recommendations.length > 0 ? `
                <div class="mt-3 p-3 bg-yellow-50 rounded-lg">
                    <h4 class="font-medium text-yellow-800 mb-2">Öneriler:</h4>
                    <ul class="list-disc list-inside text-sm text-yellow-700">
                        ${result.recommendations.map(rec => `<li>${rec}</li>`).join('')}
                    </ul>
                </div>
            ` : ''}
        </div>
    `;

    const resultsDiv = document.getElementById('testResults');
    resultsDiv.innerHTML = resultHtml;
    resultsDiv.classList.remove('hidden');

    // Smooth scroll to results
    resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function showTestResult(type, title, message) {
    const color = type === 'error' ? 'red' : type === 'warning' ? 'yellow' : 'blue';
    const icon = type === 'error' ? 'fas fa-exclamation-circle' : type === 'warning' ? 'fas fa-exclamation-triangle' : 'fas fa-info-circle';

    const resultHtml = `
        <div class="bg-${color}-50 border border-${color}-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="${icon} text-${color}-500 text-xl mr-3"></i>
                <div>
                    <h4 class="font-bold text-${color}-800">${title}</h4>
                    <p class="text-${color}-700 text-sm mt-1">${message}</p>
                </div>
            </div>
        </div>
    `;

    const resultsDiv = document.getElementById('testResults');
    resultsDiv.innerHTML = resultHtml;
    resultsDiv.classList.remove('hidden');
}
</script>
@endpush

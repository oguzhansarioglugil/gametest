@extends('layouts.app')

@section('title', 'Download System Analyzer')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Game Compatibility Analyzer
            </h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Sistem donanımınızı otomatik olarak analiz edin ve hangi oyunları oynayabileceğinizi öğrenin!
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- Download Card -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Windows İçin İndir</h2>
                    <p class="text-gray-300">Versiyon 1.0.0 • ~15MB</p>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex items-center text-green-400">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Otomatik donanım tespiti
                    </div>
                    <div class="flex items-center text-green-400">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Detaylı uyumluluk raporu
                    </div>
                    <div class="flex items-center text-green-400">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Yükseltme önerileri
                    </div>
                    <div class="flex items-center text-green-400">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Güvenli ve hızlı analiz
                    </div>
                </div>

                <button onclick="downloadAnalyzer()"
                        class="w-full bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Şimdi İndir
                </button>

                <p class="text-sm text-gray-400 text-center mt-4">
                    Windows 7/8/10/11 uyumlu • İnternet bağlantısı gerekli
                </p>
            </div>

            <!-- Instructions Card -->
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20">
                <h3 class="text-2xl font-bold text-white mb-6">Nasıl Kullanılır?</h3>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Programı İndirin</h4>
                            <p class="text-gray-300 text-sm">GameCompatibilityAnalyzer.exe dosyasını indirin ve çalıştırın.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Sistemi Tarayın</h4>
                            <p class="text-gray-300 text-sm">"Scan System" butonuna tıklayarak donanım bilgilerinizi toplayın.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold text-sm">3</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Oyunları Analiz Edin</h4>
                            <p class="text-gray-300 text-sm">"Analyze Games" butonuna tıklayarak uyumluluk raporunu alın.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-4 mt-1 flex-shrink-0">
                            <span class="text-white font-bold text-sm">4</span>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold mb-1">Sonuçları İnceleyin</h4>
                            <p class="text-gray-300 text-sm">Hangi oyunları oynayabileceğinizi ve yükseltme önerilerini görün.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-yellow-500/20 rounded-lg border border-yellow-500/30">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-yellow-400 font-semibold">Önemli Not</span>
                    </div>
                    <p class="text-yellow-100 text-sm">
                        Program çalışması için internet bağlantısı gereklidir. Donanım bilgileri güvenli şekilde analiz edilir ve saklanmaz.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-4xl mx-auto mt-16">
            <h3 class="text-3xl font-bold text-white text-center mb-8">Sık Sorulan Sorular</h3>

            <div class="space-y-4">
                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 border border-white/20">
                    <h4 class="text-white font-semibold mb-2">Program güvenli mi?</h4>
                    <p class="text-gray-300">Evet, program tamamen güvenlidir. Sadece sistem donanım bilgilerini okur ve herhangi bir kişisel veri toplamaz.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 border border-white/20">
                    <h4 class="text-white font-semibold mb-2">Hangi bilgiler toplanır?</h4>
                    <p class="text-gray-300">CPU modeli, GPU modeli, RAM miktarı, disk alanı ve işletim sistemi bilgileri toplanır. Kişisel dosyalarınıza erişim yoktur.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 border border-white/20">
                    <h4 class="text-white font-semibold mb-2">Veriler saklanır mı?</h4>
                    <p class="text-gray-300">Hayır, donanım bilgileriniz sadece analiz için kullanılır ve sunucuda saklanmaz.</p>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-lg p-6 border border-white/20">
                    <h4 class="text-white font-semibold mb-2">Programı çalıştıramıyorum?</h4>
                    <p class="text-gray-300">Windows Defender veya antivirüs programınız nedeniyle engellenebilir. Programı güvenli uygulamalar listesine ekleyin.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadAnalyzer() {
    // Show "Coming Soon" popup
    showComingSoonPopup();
}

function showComingSoonPopup() {
    // Create modal backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    backdrop.onclick = closePopup;

    // Create modal content
    const modal = document.createElement('div');
    modal.className = 'bg-white rounded-2xl p-8 max-w-md mx-4 text-center transform transition-all duration-300 scale-95';
    modal.onclick = (e) => e.stopPropagation();

    modal.innerHTML = `
        <div class="mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Çok Yakında!</h3>
            <p class="text-gray-600 mb-6">
                Otomatik sistem analizi özelliği yakında kullanıma sunulacak.
                Şu an için lütfen profil sayfanızdan sistem bilgilerinizi manuel olarak girin.
            </p>
            <div class="flex gap-3 justify-center">
                <button onclick="closePopup()"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    Tamam
                </button>
                <a href="{{ route('profile.index') }}#system"
                   class="px-6 py-2 bg-gradient-to-r from-purple-500 to-blue-600 hover:from-purple-600 hover:to-blue-700 text-white rounded-lg transition-all">
                    Profil Sayfası
                </a>
            </div>
        </div>
    `;

    backdrop.appendChild(modal);
    document.body.appendChild(backdrop);

    // Animate in
    setTimeout(() => {
        modal.classList.remove('scale-95');
        modal.classList.add('scale-100');
    }, 10);
}

function closePopup() {
    const backdrop = document.querySelector('.fixed.inset-0.bg-black');
    if (backdrop) {
        const modal = backdrop.querySelector('.bg-white');
        modal.classList.remove('scale-100');
        modal.classList.add('scale-95');
        setTimeout(() => {
            backdrop.remove();
        }, 300);
    }
}
</script>
@endsection

<footer class="bg-gray-800 text-white mt-16">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo ve Açıklama -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-purple-600 p-2 rounded-lg">
                        <i class="fas fa-gamepad text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">GameTest</h3>
                        <p class="text-gray-400 text-sm">Sistem Karşılaştırma</p>
                    </div>
                </div>
                <p class="text-gray-300 mb-4">
                    Oyunların sistem gereksinimlerini karşılaştırın ve bilgisayarınızın hangi oyunları çalıştırabileceğini öğrenin.
                    Hem minimum hem de önerilen sistem gereksinimlerini detaylı olarak inceleyin.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Hızlı Linkler -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hızlı Linkler</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">Anasayfa</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Tüm Oyunlar</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Popüler Oyunlar</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Yeni Çıkanlar</a></li>
                </ul>
            </div>

            <!-- Destek -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Destek</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Yardım Merkezi</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">İletişim</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Gizlilik Politikası</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Kullanım Şartları</a></li>
                </ul>
            </div>
        </div>

        <!-- Alt Çizgi -->
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} GameTest. Tüm hakları saklıdır.
                </p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <span class="text-gray-400 text-sm">Toplam {{ \App\Models\Game::count() }} oyun</span>
                    <span class="text-gray-400 text-sm">•</span>
                    <span class="text-gray-400 text-sm">{{ \App\Models\HardwareModel::count() }} donanım</span>
                </div>
            </div>
        </div>
    </div>
</footer>

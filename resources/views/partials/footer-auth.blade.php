<footer class="bg-gray-800 text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Logo ve Açıklama -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-purple-600 p-2 rounded-lg">
                        <i class="fas fa-gamepad text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">GameTest</h3>
                        <p class="text-gray-400 text-sm">Sistem Karşılaştırma</p>
                    </div>
                </div>
                <p class="text-gray-300 mb-4 text-sm">
                    Oyunların sistem gereksinimlerini karşılaştırın ve bilgisayarınızın hangi oyunları çalıştırabileceğini öğrenin.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-github text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Hızlı Linkler -->
            <div>
                <h4 class="text-md font-semibold mb-3">Hızlı Linkler</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Anasayfa</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Tüm Oyunlar</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Popüler Oyunlar</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Yeni Çıkanlar</a></li>
                </ul>
            </div>

            <!-- Destek -->
            <div>
                <h4 class="text-md font-semibold mb-3">Destek</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Yardım Merkezi</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">İletişim</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Gizlilik Politikası</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Kullanım Şartları</a></li>
                </ul>
            </div>
        </div>

        <!-- Alt Çizgi -->
        <div class="border-t border-gray-700 mt-6 pt-6 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} GameTest. Tüm hakları saklıdır.
                </p>
                <div class="flex items-center space-x-4 mt-2 md:mt-0">
                    <span class="text-gray-400 text-sm">Toplam {{ \App\Models\Game::count() }} oyun</span>
                    <span class="text-gray-400 text-sm">•</span>
                    <span class="text-gray-400 text-sm">{{ \App\Models\HardwareModel::count() }} donanım</span>
                </div>
            </div>
        </div>
    </div>
</footer>

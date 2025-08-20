<header class="gradient-bg shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <nav class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 text-white hover:text-gray-200 transition-colors">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                        <i class="fas fa-gamepad text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">GameTest</h1>
                        <p class="text-sm text-gray-200">Sistem Karşılaştırma</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                    <i class="fas fa-home"></i>
                    <span>Anasayfa</span>
                </a>
                <a href="{{ route('games.index') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                    <i class="fas fa-list"></i>
                    <span>Tüm Oyunlar</span>
                </a>
                <a href="{{ route('download') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                    <i class="fas fa-download"></i>
                    <span>Sistem Analiz</span>
                </a>

                @auth
                    <!-- Giriş yapmış kullanıcı menüsü -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-user mr-2"></i>
                                Profilim
                            </a>
                            <a href="{{ route('profile.index') }}#system" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-desktop mr-2"></i>
                                Sistemim
                            </a>

                            @if(Auth::user()->isAdmin())
                                <hr class="my-2">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-purple-600 hover:bg-purple-50 transition-colors font-medium">
                                    <i class="fas fa-cog mr-2"></i>
                                    Admin Panel
                                    <span class="ml-auto text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">{{ Auth::user()->getRoleDisplayName() }}</span>
                                </a>
                            @endif

                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-cog mr-2"></i>
                                Ayarlar
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Giriş yapmamış kullanıcı menüsü -->
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Giriş Yap</span>
                    </a>
                    <a href="{{ route('register') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors flex items-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Kayıt Ol</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button class="text-white hover:text-gray-200 transition-colors" x-data @click="$dispatch('toggle-mobile-menu')">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="md:hidden mt-4 pb-4 border-t border-white border-opacity-20" x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-transition>
            <div class="flex flex-col space-y-3 mt-4">
                <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                    <i class="fas fa-home"></i>
                    <span>Anasayfa</span>
                </a>
                <a href="{{ route('games.index') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                    <i class="fas fa-list"></i>
                    <span>Tüm Oyunlar</span>
                </a>
                <a href="{{ route('download') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                    <i class="fas fa-download"></i>
                    <span>Sistem Analiz</span>
                </a>

                @auth
                    <!-- Mobile - Giriş yapmış kullanıcı -->
                    <div class="border-t border-white border-opacity-20 pt-3 mt-3">
                        <p class="text-gray-200 text-sm mb-2">Hoş geldin, {{ Auth::user()->name }}!</p>
                        <a href="{{ route('profile.index') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2 mb-2">
                            <i class="fas fa-user"></i>
                            <span>Profilim</span>
                        </a>
                        <a href="{{ route('profile.index') }}#system" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2 mb-2">
                            <i class="fas fa-desktop"></i>
                            <span>Sistemim</span>
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-purple-200 hover:text-purple-100 transition-colors flex items-center space-x-2 mb-2 font-medium">
                                <i class="fas fa-cog"></i>
                                <span>Admin Panel</span>
                            </a>
                        @endif
                        <a href="#" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2 mb-2">
                            <i class="fas fa-cog"></i>
                            <span>Ayarlar</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="text-red-200 hover:text-red-100 transition-colors flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Çıkış Yap</span>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Mobile - Giriş yapmamış kullanıcı -->
                    <div class="border-t border-white border-opacity-20 pt-3 mt-3">
                        <a href="{{ route('login') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2 mb-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Giriş Yap</span>
                        </a>
                        <a href="{{ route('register') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                            <i class="fas fa-user-plus"></i>
                            <span>Kayıt Ol</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>

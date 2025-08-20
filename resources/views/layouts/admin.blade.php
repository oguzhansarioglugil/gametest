<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - GameTest</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex items-center justify-center h-16 px-4 bg-gray-800">
                <h1 class="text-xl font-bold text-white">
                    <i class="fas fa-cog mr-2"></i>
                    Admin Panel
                </h1>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-8">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <!-- Oyun Yönetimi - Tüm adminler erişebilir -->
                <a href="{{ route('admin.games.index') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.games.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
                    <i class="fas fa-gamepad mr-3"></i>
                    Oyun Yönetimi
                </a>

                @if(Auth::user()->isSuperAdmin())
                    <!-- Kullanıcı Yönetimi - Sadece SuperAdmin -->
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Kullanıcı Yönetimi
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">SuperAdmin</span>
                    </a>

                    <!-- Donanım Yönetimi - Sadece SuperAdmin -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.hardware.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
                            <i class="fas fa-microchip mr-3"></i>
                            Donanım Yönetimi
                            <div class="ml-auto flex items-center space-x-2">
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">SuperAdmin</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             class="bg-gray-800 border-t border-gray-700">
                            <a href="{{ route('admin.hardware.brands.index') }}"
                               class="flex items-center px-12 py-3 text-gray-300 hover:bg-gray-600 hover:text-white transition-colors text-sm {{ request()->routeIs('admin.hardware.brands.*') ? 'bg-gray-600 text-white' : '' }}">
                                <i class="fas fa-tags mr-2 text-xs"></i>
                                Markalar
                            </a>
                            <a href="{{ route('admin.hardware.models.index') }}"
                               class="flex items-center px-12 py-3 text-gray-300 hover:bg-gray-600 hover:text-white transition-colors text-sm {{ request()->routeIs('admin.hardware.models.*') ? 'bg-gray-600 text-white' : '' }}">
                                <i class="fas fa-microchip mr-2 text-xs"></i>
                                Modeller
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Normal Admin için disabled -->
                    <div class="flex items-center px-6 py-3 text-gray-500 cursor-not-allowed">
                        <i class="fas fa-users mr-3"></i>
                        Kullanıcı Yönetimi
                        <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Yakında</span>
                    </div>

                    <!-- Donanım Yönetimi - Normal Admin için disabled -->
                    <div class="flex items-center px-6 py-3 text-gray-500 cursor-not-allowed">
                        <i class="fas fa-microchip mr-3"></i>
                        Donanım Yönetimi
                        <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Yakında</span>
                    </div>
                @endif

                @if(Auth::user()->isSuperAdmin())
                    <!-- Sistem Ayarları - Sadece SuperAdmin -->
                    <a href="{{ route('admin.settings') }}"
                       class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.settings') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
                        <i class="fas fa-cog mr-3"></i>
                        Sistem Ayarları
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">SuperAdmin</span>
                    </a>

                    <!-- Admin Yönetimi - Sadece SuperAdmin -->
                    <a href="{{ route('admin.admins.index') }}"
                       class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('admin.admins.*') ? 'bg-gray-700 text-white border-r-4 border-blue-500' : '' }}">
                        <i class="fas fa-user-shield mr-3"></i>
                        Admin Yönetimi
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">SuperAdmin</span>
                    </a>
                @endif

                <!-- Divider -->
                <div class="border-t border-gray-700 my-4"></div>

                <!-- Ana Siteye Git -->
                <a href="{{ route('home') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    Ana Siteye Git
                </a>

                <!-- Çıkış Yap -->
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-red-600 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Çıkış Yap
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Page Title -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Admin Panel')</h1>
                        <p class="text-sm text-gray-600">@yield('page-description', 'Yönetim paneline hoş geldiniz')</p>
                    </div>

                    <!-- User Info -->
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }} {{ auth()->user()->surname }}</p>
                            <div class="flex items-center justify-end space-x-2">
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                {!! auth()->user()->getRoleBadgeHtml() !!}
                            </div>
                        </div>
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </div>
                        <!-- Çıkış Butonu -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors"
                                    title="Çıkış Yap">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                Çıkış
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Success Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                            <div class="text-green-800 font-medium">{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3 mt-0.5"></i>
                            <div>
                                <div class="text-red-800 font-medium mb-2">Bir hata oluştu:</div>
                                <ul class="text-red-700 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         @click="sidebarOpen = false">
    </div>

    @stack('scripts')

    <style>
    /* Super Admin badge efekti */
    .super-admin-badge {
        position: relative;
        background: linear-gradient(135deg, #fecaca, #f87171) !important;
        color: #7f1d1d !important;
        animation: shimmer 2s infinite;
        border: 1px solid #dc2626;
    }

    @keyframes shimmer {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Admin pulse efekti */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: .8;
            transform: scale(1.02);
        }
    }
    </style>
</body>
</html>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GameTest - Oyun Sistem Karşılaştırma')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .search-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Minimal Header for Auth Pages -->
    <header class="absolute top-0 left-0 right-0 z-10">
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

                <!-- Back to Home Link -->
                <div>
                    <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition-colors flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Anasayfaya Dön</span>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Notifications -->
    @if(session('success') || session('error') || session('warning') || session('info'))
        <div class="fixed top-20 right-4 z-50" x-data="{ show: true }" x-show="show" x-transition>
            @if(session('success'))
                <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg mb-4 flex items-center space-x-3">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="ml-4 text-green-200 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg mb-4 flex items-center space-x-3">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <span>{{ session('error') }}</span>
                    <button @click="show = false" class="ml-4 text-red-200 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg mb-4 flex items-center space-x-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <span>{{ session('warning') }}</span>
                    <button @click="show = false" class="ml-4 text-yellow-200 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg mb-4 flex items-center space-x-3">
                    <i class="fas fa-info-circle text-xl"></i>
                    <span>{{ session('info') }}</span>
                    <button @click="show = false" class="ml-4 text-blue-200 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Auto-hide notification after 5 seconds -->
        <script>
            setTimeout(() => {
                const notification = document.querySelector('[x-data*="show: true"]');
                if (notification) {
                    notification.__x.$data.show = false;
                }
            }, 5000);
        </script>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer-auth')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>

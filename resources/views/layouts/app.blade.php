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
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    @include('partials.header')

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
    @include('partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>

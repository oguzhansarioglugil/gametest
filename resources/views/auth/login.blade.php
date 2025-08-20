@extends('layouts.auth')

@section('title', 'Giriş Yap - GameTest')

@section('content')
<div class="flex-1 flex items-center justify-center bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo ve Başlık -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-gamepad text-2xl text-purple-600"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white">
                Hesabınıza Giriş Yapın
            </h2>
            <p class="mt-2 text-sm text-purple-200">
                Henüz hesabınız yok mu?
                <a href="{{ route('register') }}" class="font-medium text-white hover:text-purple-200 transition-colors">
                    Hemen kayıt olun
                </a>
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form class="space-y-6" action="{{ route('login') }}" method="POST" x-data="loginForm()">
                @csrf

                <!-- E-posta -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-purple-600"></i>
                        E-posta Adresi
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:z-10 transition-colors @error('email') border-red-500 @enderror"
                        placeholder="ornek@email.com"
                        x-model="email"
                        @input="validateEmail()"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Şifre -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-purple-600"></i>
                        Şifre
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            autocomplete="current-password"
                            required
                            class="appearance-none relative block w-full px-4 py-3 pr-12 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:z-10 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="Şifrenizi giriniz"
                            x-model="password"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Beni Hatırla -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Beni hatırla
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-purple-600 hover:text-purple-500 transition-colors">
                            Şifremi unuttum
                        </a>
                    </div>
                </div>

                <!-- Giriş Butonu -->
                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-105"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-purple-300 group-hover:text-purple-200"></i>
                        </span>
                        Giriş Yap
                    </button>
                </div>

                <!-- Sosyal Medya Girişi (Gelecekte eklenebilir) -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">veya</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-shield-alt mr-1 text-green-500"></i>
                            Güvenli giriş sistemi
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function loginForm() {
    return {
        email: '{{ old('email') }}',
        password: '',
        showPassword: false,
        emailValid: true, // Başlangıçta true yapıyoruz

        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.emailValid = emailRegex.test(this.email);
        },

        init() {
            if (this.email) {
                this.validateEmail();
            }
        }
    }
}
</script>
@endpush

@push('styles')
<style>
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

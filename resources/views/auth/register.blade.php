@extends('layouts.auth')

@section('title', 'Kayıt Ol - GameTest')

@section('content')
<div class="flex-1 flex items-center justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-8">
        <!-- Logo ve Başlık -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-user-plus text-2xl text-indigo-600"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-white">
                Yeni Hesap Oluşturun
            </h2>
            <p class="mt-2 text-sm text-purple-200">
                Zaten hesabınız var mı?
                <a href="{{ route('login') }}" class="font-medium text-white hover:text-purple-200 transition-colors">
                    Giriş yapın
                </a>
            </p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form class="space-y-6" action="{{ route('register') }}" method="POST" x-data="registerForm()">
                @csrf

                <!-- Ad ve Soyad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Ad -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-indigo-600"></i>
                            Ad
                        </label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="given-name"
                            required
                            value="{{ old('name') }}"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Adınız"
                            x-model="name"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Soyad -->
                    <div>
                        <label for="surname" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-indigo-600"></i>
                            Soyad
                        </label>
                        <input
                            id="surname"
                            name="surname"
                            type="text"
                            autocomplete="family-name"
                            required
                            value="{{ old('surname') }}"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('surname') border-red-500 @enderror"
                            placeholder="Soyadınız"
                            x-model="surname"
                        >
                        @error('surname')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Kullanıcı Adı -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-at mr-2 text-indigo-600"></i>
                        Kullanıcı Adı
                    </label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        autocomplete="username"
                        required
                        value="{{ old('username') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('username') border-red-500 @enderror"
                        placeholder="kullaniciadi"
                        x-model="username"
                        @input="validateUsername()"
                    >
                    <p class="mt-1 text-xs text-gray-500" x-show="username.length > 0">
                        <span :class="usernameValid ? 'text-green-600' : 'text-red-600'">
                            <i :class="usernameValid ? 'fas fa-check' : 'fas fa-times'" class="mr-1"></i>
                            <span x-text="usernameValid ? 'Kullanıcı adı uygun' : 'En az 3 karakter, sadece harf, rakam ve alt çizgi'"></span>
                        </span>
                    </p>
                    @error('username')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- E-posta -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-600"></i>
                        E-posta Adresi
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('email') border-red-500 @enderror"
                        placeholder="ornek@email.com"
                        x-model="email"
                        @input="validateEmail()"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Doğum Tarihi -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-indigo-600"></i>
                        Doğum Tarihi
                    </label>
                    <input
                        id="birth_date"
                        name="birth_date"
                        type="date"
                        required
                        value="{{ old('birth_date') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('birth_date') border-red-500 @enderror"
                        x-model="birthDate"
                        @input="validateAge()"
                        :max="maxDate"
                    >
                    <p class="mt-1 text-xs text-gray-500" x-show="birthDate">
                        <span :class="ageValid ? 'text-green-600' : 'text-red-600'">
                            <i :class="ageValid ? 'fas fa-check' : 'fas fa-times'" class="mr-1"></i>
                            <span x-text="ageText"></span>
                        </span>
                    </p>
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Şifre -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>
                        Şifre
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            :type="showPassword ? 'text' : 'password'"
                            autocomplete="new-password"
                            required
                            class="appearance-none relative block w-full px-4 py-3 pr-12 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="En az 6 karakter"
                            x-model="password"
                            @input="validatePassword()"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    <!-- Şifre Güçlülük Göstergesi -->
                    <div class="mt-2" x-show="password.length > 0">
                        <div class="flex space-x-1">
                            <div class="h-2 flex-1 rounded" :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                            <div class="h-2 flex-1 rounded" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                            <div class="h-2 flex-1 rounded" :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
                        </div>
                        <p class="mt-1 text-xs" :class="passwordStrengthColor">
                            <span x-text="passwordStrengthText"></span>
                        </p>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Şifre Tekrarı -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>
                        Şifre Tekrarı
                    </label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            :type="showPasswordConfirm ? 'text' : 'password'"
                            autocomplete="new-password"
                            required
                            class="appearance-none relative block w-full px-4 py-3 pr-12 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            :class="{ 'border-red-500': passwordConfirmation.length > 0 && !passwordsMatch, 'border-green-500': passwordConfirmation.length > 0 && passwordsMatch }"
                            placeholder="Şifrenizi tekrar giriniz"
                            x-model="passwordConfirmation"
                        >
                        <button
                            type="button"
                            @click="showPasswordConfirm = !showPasswordConfirm"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i :class="showPasswordConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-xs" x-show="passwordConfirmation.length > 0">
                        <span :class="passwordsMatch ? 'text-green-600' : 'text-red-600'">
                            <i :class="passwordsMatch ? 'fas fa-check' : 'fas fa-times'" class="mr-1"></i>
                            <span x-text="passwordsMatch ? 'Şifreler eşleşiyor' : 'Şifreler eşleşmiyor'"></span>
                        </span>
                    </p>
                </div>

                                            <!-- Kayıt Butonu -->
                            <div>
                                <button
                                    type="submit"
                                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105"
                                >
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <i class="fas fa-user-plus text-indigo-300 group-hover:text-indigo-200"></i>
                                    </span>
                                    Hesap Oluştur
                                </button>
                            </div>

                <!-- Kullanım Şartları -->
                <div class="text-center">
                    <p class="text-xs text-gray-600">
                        Kayıt olarak
                        <a href="#" class="text-indigo-600 hover:text-indigo-500">Kullanım Şartları</a>
                        ve
                        <a href="#" class="text-indigo-600 hover:text-indigo-500">Gizlilik Politikası</a>'nı
                        kabul etmiş olursunuz.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function registerForm() {
    return {
        name: '{{ old('name') }}',
        surname: '{{ old('surname') }}',
        username: '{{ old('username') }}',
        email: '{{ old('email') }}',
        birthDate: '{{ old('birth_date') }}',
        password: '',
        passwordConfirmation: '',
        showPassword: false,
        showPasswordConfirm: false,
        emailValid: false,
        usernameValid: false,
        ageValid: false,
        passwordStrength: 0,

        get maxDate() {
            const today = new Date();
            today.setFullYear(today.getFullYear() - 13); // En az 13 yaş
            return today.toISOString().split('T')[0];
        },

        get isFormValid() {
            // Form validasyonunu kaldırıyoruz, server-side validation kullanacağız
            return true;
        },

        get passwordsMatch() {
            return this.password === this.passwordConfirmation && this.passwordConfirmation.length > 0;
        },

        get passwordStrengthText() {
            switch(this.passwordStrength) {
                case 1: return 'Zayıf şifre';
                case 2: return 'Orta güçlükte şifre';
                case 3: return 'Güçlü şifre';
                default: return '';
            }
        },

        get passwordStrengthColor() {
            switch(this.passwordStrength) {
                case 1: return 'text-red-600';
                case 2: return 'text-yellow-600';
                case 3: return 'text-green-600';
                default: return 'text-gray-600';
            }
        },

        get ageText() {
            if (!this.birthDate) return '';

            const today = new Date();
            const birth = new Date(this.birthDate);
            const age = today.getFullYear() - birth.getFullYear();

            if (age < 13) {
                return 'En az 13 yaşında olmalısınız';
            }

            return `${age} yaşındasınız`;
        },

        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            this.emailValid = emailRegex.test(this.email);
        },

        validateUsername() {
            const usernameRegex = /^[a-zA-Z0-9_]{3,}$/;
            this.usernameValid = usernameRegex.test(this.username);
        },

        validateAge() {
            if (!this.birthDate) {
                this.ageValid = false;
                return;
            }

            const today = new Date();
            const birth = new Date(this.birthDate);
            const age = today.getFullYear() - birth.getFullYear();

            this.ageValid = age >= 13;
        },

        validatePassword() {
            let strength = 0;

            if (this.password.length >= 6) strength++;
            if (this.password.match(/[a-z]/) && this.password.match(/[A-Z]/)) strength++;
            if (this.password.match(/[0-9]/) && this.password.match(/[^a-zA-Z0-9]/)) strength++;

            this.passwordStrength = strength;
        },

        init() {
            this.validateEmail();
            this.validateUsername();
            this.validateAge();
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

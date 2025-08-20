@extends('layouts.admin')

@section('title', 'Admin Yönetimi - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Admin Yönetimi</h1>
            <p class="text-gray-600">Yönetici hesaplarını görüntüleyin ve yönetin</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="fas fa-shield-alt mr-1"></i>
                Sadece SuperAdmin
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-user-shield text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">SuperAdmin</p>
                    <p class="text-lg font-semibold">{{ $admins->where('role', 'super_admin')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-user-cog text-orange-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Admin</p>
                    <p class="text-lg font-semibold">{{ $admins->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Toplam</p>
                    <p class="text-lg font-semibold">{{ $admins->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Yönetici Listesi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Yönetici
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İletişim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol & Rank
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Yetki Tarihi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($admins as $admin)
                        <tr class="hover:bg-gray-50 {{ $admin->role === 'super_admin' ? 'bg-red-50' : 'bg-orange-50' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 {{ $admin->role === 'super_admin' ? 'bg-red-300' : 'bg-orange-300' }} rounded-full flex items-center justify-center">
                                        <i class="fas fa-{{ $admin->role === 'super_admin' ? 'user-shield' : 'user-cog' }} text-white"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $admin->name }} {{ $admin->surname }}
                                            @if($admin->id === Auth::id())
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full ml-2">Siz</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">@{{ $admin->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $admin->email }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $admin->birth_date ? $admin->birth_date->format('d.m.Y') : 'Belirtilmemiş' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    {!! $admin->getRoleBadgeHtml() !!}
                                    {!! $admin->getRankBadgeHtml() !!}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ number_format($admin->experience_points) }} XP
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $admin->created_at->format('d.m.Y H:i') }}
                                <div class="text-xs text-gray-400">
                                    {{ $admin->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.users.show', $admin) }}"
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($admin->id !== Auth::id())
                                    <!-- Role Change -->
                                    <div class="inline-block relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                                class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-user-cog"></i>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                            <div class="py-1">
                                                @if($admin->role === 'super_admin')
                                                    <form action="{{ route('admin.users.update-role', $admin) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="role" value="admin">
                                                        <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                onclick="return confirm('{{ $admin->name }} kullanıcısının SuperAdmin yetkisini kaldırmak istediğinizden emin misiniz?')">
                                                            Admin Yap
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.users.update-role', $admin) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="role" value="user">
                                                        <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                                                onclick="return confirm('{{ $admin->name }} kullanıcısının tüm yönetici yetkilerini kaldırmak istediğinizden emin misiniz?')">
                                                            Kullanıcı Yap
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.users.update-role', $admin) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="role" value="super_admin">
                                                        <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                                                onclick="return confirm('{{ $admin->name }} kullanıcısına SuperAdmin yetkisi vermek istediğinizden emin misiniz?')">
                                                            SuperAdmin Yap
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.users.update-role', $admin) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="role" value="user">
                                                        <button type="submit"
                                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                onclick="return confirm('{{ $admin->name }} kullanıcısının admin yetkisini kaldırmak istediğinizden emin misiniz?')">
                                                            Kullanıcı Yap
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $admins->links() }}
        </div>
    </div>

    <!-- Admin Yetkileri Açıklaması -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-blue-900 mb-4">
            <i class="fas fa-info-circle mr-2"></i>
            Yönetici Yetkileri
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-red-800 mb-2">
                    <i class="fas fa-user-shield mr-2"></i>
                    SuperAdmin Yetkileri
                </h4>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Tüm kullanıcıları görüntüleme ve yönetme</li>
                    <li>• Kullanıcı rollerini değiştirme</li>
                    <li>• Sistem ayarlarını değiştirme</li>
                    <li>• Admin hesaplarını yönetme</li>
                    <li>• Oyun yönetimi (CRUD işlemleri)</li>
                    <li>• Donanım yönetimi (yakında)</li>
                </ul>
            </div>

            <div>
                <h4 class="font-medium text-orange-800 mb-2">
                    <i class="fas fa-user-cog mr-2"></i>
                    Admin Yetkileri
                </h4>
                <ul class="text-sm text-orange-700 space-y-1">
                    <li>• Oyun yönetimi (CRUD işlemleri)</li>
                    <li>• Donanım yönetimi (yakında)</li>
                    <li>• Dashboard görüntüleme</li>
                    <li class="text-gray-500">• Kullanıcı yönetimi (sadece SuperAdmin)</li>
                    <li class="text-gray-500">• Sistem ayarları (sadece SuperAdmin)</li>
                    <li class="text-gray-500">• Admin yönetimi (sadece SuperAdmin)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

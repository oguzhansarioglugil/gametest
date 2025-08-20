@extends('layouts.admin')

@section('title', 'Kullanıcı Yönetimi - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kullanıcı Yönetimi</h1>
            <p class="text-gray-600">Tüm kullanıcıları görüntüleyin ve yönetin</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                <i class="fas fa-shield-alt mr-1"></i>
                Sadece SuperAdmin
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Toplam Kullanıcı</p>
                    <p class="text-lg font-semibold">{{ $users->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-user text-green-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">Normal Kullanıcı</p>
                    <p class="text-lg font-semibold">{{ $users->where('role', 'user')->count() }}</p>
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
                    <p class="text-lg font-semibold">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-user-shield text-red-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-600">SuperAdmin</p>
                    <p class="text-lg font-semibold">{{ $users->where('role', 'super_admin')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Kullanıcı Listesi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kullanıcı
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İletişim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol & Rank
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kayıt Tarihi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }} {{ $user->surname }}
                                        </div>
                                        <div class="text-sm text-gray-500">@{{ $user->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Belirtilmemiş' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    {!! $user->getRoleBadgeHtml() !!}
                                    {!! $user->getRankBadgeHtml() !!}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ number_format($user->experience_points) }} XP
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d.m.Y H:i') }}
                                <div class="text-xs text-gray-400">
                                    {{ $user->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($user->id !== Auth::id())
                                    <!-- Role Change Dropdown -->
                                    <div class="inline-block relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                                class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-user-cog"></i>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                            <div class="py-1">
                                                @foreach(['user' => 'Kullanıcı', 'admin' => 'Admin', 'super_admin' => 'SuperAdmin'] as $role => $label)
                                                    @if($user->role !== $role)
                                                        <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="role" value="{{ $role }}">
                                                            <button type="submit"
                                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                    onclick="return confirm('{{ $user->name }} kullanıcısının rolünü {{ $label }} yapmak istediğinizden emin misiniz?')">
                                                                {{ $label }} Yap
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rank Change Dropdown -->
                                    <div class="inline-block relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                                class="text-yellow-600 hover:text-yellow-900"
                                                title="Rank Değiştir">
                                            <i class="fas fa-crown"></i>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                             class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-10 max-h-80 overflow-y-auto">
                                            <div class="py-1">
                                                <div class="px-4 py-2 text-xs font-medium text-gray-500 border-b">
                                                    Rank Seçin
                                                </div>
                                                @php $rankLevels = App\Models\User::getRankLevels(); @endphp
                                                @foreach($rankLevels as $rank => $data)
                                                    @if($user->rank !== $rank)
                                                        <form action="{{ route('admin.users.update-rank', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="rank" value="{{ $rank }}">
                                                            <button type="submit"
                                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                                    onclick="return confirm('{{ $user->name }} kullanıcısının rank\'ini {{ $rank }} yapmak istediğinizden emin misiniz?')">
                                                                <span class="flex items-center justify-between">
                                                                    <span>{{ $data['icon'] }} {{ $rank }}</span>
                                                                    <span class="text-xs text-gray-500">{{ number_format($data['min_exp']) }} XP</span>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
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
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

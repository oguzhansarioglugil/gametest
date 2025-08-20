<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSystem;
use App\Models\HardwareBrand;
use App\Models\HardwareModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Profil sayfasını göster
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userSystem = $user->systems()->first();

        // Aktif tab belirleme (URL'den veya session'dan)
        $activeTab = $request->get('tab', session('activeTab', 'profile'));

        // Hardware models with brands - CPU ve GPU'ları marka ile birlikte getir
        $cpuModels = HardwareModel::with('brand')
            ->where('type', 'cpu')
            ->orderBy('brand_id')
            ->orderBy('name')
            ->get();

        $gpuModels = HardwareModel::with('brand')
            ->where('type', 'gpu')
            ->orderBy('brand_id')
            ->orderBy('name')
            ->get();

        // Rank bilgileri
        $nextRank = $user->getNextRankExperience();
        $rankProgress = $user->getRankProgress();
        $rankLevels = User::getRankLevels();

        return view('profile.index', compact('user', 'userSystem', 'cpuModels', 'gpuModels', 'nextRank', 'rankProgress', 'rankLevels', 'activeTab'));
    }

    /**
     * Kişisel bilgileri güncelle
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'birth_date' => 'required|date|before:today',
        ], [
            'name.required' => 'Ad gereklidir.',
            'surname.required' => 'Soyad gereklidir.',
            'username.required' => 'Kullanıcı adı gereklidir.',
            'username.unique' => 'Bu kullanıcı adı zaten kullanılıyor.',
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'birth_date.required' => 'Doğum tarihi gereklidir.',
            'birth_date.before' => 'Geçerli bir doğum tarihi giriniz.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('activeTab', 'profile');
        }

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
        ]);

        return back()->with('success', 'Profil bilgileriniz başarıyla güncellendi!')->with('activeTab', 'profile');
    }

    /**
     * Şifreyi güncelle
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Mevcut şifre gereklidir.',
            'password.required' => 'Yeni şifre gereklidir.',
            'password.min' => 'Yeni şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('activeTab', 'password');
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifre yanlış.'])->with('activeTab', 'password');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Şifreniz başarıyla güncellendi!')->with('activeTab', 'password');
    }

    /**
     * Sistem bilgilerini güncelle
     */
    public function updateSystem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cpu_id' => 'required|exists:hardware_models,id',
            'gpu_id' => 'required|exists:hardware_models,id',
            'ram' => 'required|integer|min:1|max:256',
            'disk' => 'required|integer|min:1|max:10000',
            'system_name' => 'nullable|string|max:255',
        ], [
            'cpu_id.required' => 'CPU seçimi gereklidir.',
            'cpu_id.exists' => 'Geçersiz CPU seçimi.',
            'gpu_id.required' => 'GPU seçimi gereklidir.',
            'gpu_id.exists' => 'Geçersiz GPU seçimi.',
            'ram.required' => 'RAM miktarı gereklidir.',
            'ram.integer' => 'RAM miktarı sayı olmalıdır.',
            'ram.min' => 'RAM en az 1 GB olmalıdır.',
            'ram.max' => 'RAM en fazla 256 GB olabilir.',
            'disk.required' => 'Disk alanı gereklidir.',
            'disk.integer' => 'Disk alanı sayı olmalıdır.',
            'disk.min' => 'Disk alanı en az 1 GB olmalıdır.',
            'disk.max' => 'Disk alanı en fazla 10000 GB olabilir.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('activeTab', 'system');
        }

        $user = Auth::user();

        // Mevcut sistem varsa güncelle, yoksa yeni oluştur
        $userSystem = $user->systems()->first();

        if ($userSystem) {
            $userSystem->update([
                'cpu_id' => $request->cpu_id,
                'gpu_id' => $request->gpu_id,
                'ram' => $request->ram,
                'disk' => $request->disk,
                'name' => $request->system_name ?: 'Bilgisayarım',
            ]);
        } else {
            $user->systems()->create([
                'cpu_id' => $request->cpu_id,
                'gpu_id' => $request->gpu_id,
                'ram' => $request->ram,
                'disk' => $request->disk,
                'name' => $request->system_name ?: 'Bilgisayarım',
            ]);

            // İlk sistem eklemesi için deneyim puanı ver
            $user->addExperience(25);
        }

        return back()->with('success', 'Sistem bilgileriniz başarıyla güncellendi!')->with('activeTab', 'system');
    }

    /**
     * Test için deneyim puanı ekle
     */
    public function addTestExperience()
    {
        $user = Auth::user();
        $result = $user->addExperience(50);

        $message = "50 deneyim puanı eklendi! ";
        if ($result['rank_up']) {
            $message .= "Tebrikler! {$result['old_rank']} → {$result['new_rank']} seviyesine yükseldiniz!";
        }

        return back()->with('success', $message)->with('activeTab', 'rank');
    }
}

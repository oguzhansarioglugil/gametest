<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GameManagementController;
use App\Http\Controllers\Admin\HardwareManagementController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Api\SystemAnalysisController;
use Illuminate\Http\Request;

// Anasayfa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Canlı arama (AJAX)
Route::get('/api/search', [HomeController::class, 'liveSearch'])->name('api.search');

// Oyunlar sayfası
Route::get('/games', [GamesController::class, 'index'])->name('games.index');

// Oyun detay sayfası
Route::get('/game/{id}', [GameController::class, 'show'])->name('game.show');

// Sistem test sayfası (giriş gerekli)
Route::middleware('auth')->group(function () {
    Route::get('/game/{id}/system-test', [GameController::class, 'systemTest'])->name('game.system-test');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Profile Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/system', [ProfileController::class, 'updateSystem'])->name('profile.system');
    Route::post('/profile/add-experience', [ProfileController::class, 'addTestExperience'])->name('profile.add-experience');
});

// Download routes
Route::get('/download', [DownloadController::class, 'index'])->name('download');
Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads'); // Add this alias



// Admin Routes (Admin Auth Required)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Tüm adminler dashboard'a erişebilir
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Oyun yönetimi - tüm adminler erişebilir
    // ÖNEMLI: bulk-delete route'unu resource route'larından ÖNCE tanımlayın
    Route::delete('/games/bulk-delete', [GameManagementController::class, 'bulkDelete'])->name('games.bulk-delete');

    // Autocomplete endpoints for CPU and GPU
    Route::get('/api/search/cpus', [GameManagementController::class, 'searchCpus'])->name('api.search.cpus');
    Route::get('/api/search/gpus', [GameManagementController::class, 'searchGpus'])->name('api.search.gpus');

    Route::resource('games', GameManagementController::class);
});

// Super Admin Only Routes
Route::middleware(['auth', 'admin:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kullanıcı yönetimi (sadece SuperAdmin)
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::post('/users/{user}/update-role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::post('/users/{user}/update-rank', [AdminController::class, 'updateUserRank'])->name('users.update-rank');
    Route::post('/users/{user}/update-experience', [AdminController::class, 'updateUserExperience'])->name('users.update-experience');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');

    // Donanım yönetimi (sadece SuperAdmin)
    // Hardware Brands
    Route::get('/hardware/brands', [HardwareManagementController::class, 'brands'])->name('hardware.brands.index');
    Route::get('/hardware/brands/create', [HardwareManagementController::class, 'createBrand'])->name('hardware.brands.create');
    Route::post('/hardware/brands', [HardwareManagementController::class, 'storeBrand'])->name('hardware.brands.store');
    Route::get('/hardware/brands/{brand}/edit', [HardwareManagementController::class, 'editBrand'])->name('hardware.brands.edit');
    Route::put('/hardware/brands/{brand}', [HardwareManagementController::class, 'updateBrand'])->name('hardware.brands.update');
    Route::delete('/hardware/brands/{brand}', [HardwareManagementController::class, 'destroyBrand'])->name('hardware.brands.destroy');

    // Hardware Models
    Route::get('/hardware/models', [HardwareManagementController::class, 'models'])->name('hardware.models.index');
    Route::get('/hardware/models/create', [HardwareManagementController::class, 'createModel'])->name('hardware.models.create');
    Route::post('/hardware/models', [HardwareManagementController::class, 'storeModel'])->name('hardware.models.store');
    Route::get('/hardware/models/{model}/edit', [HardwareManagementController::class, 'editModel'])->name('hardware.models.edit');
    Route::put('/hardware/models/{model}', [HardwareManagementController::class, 'updateModel'])->name('hardware.models.update');
    Route::delete('/hardware/models/{model}', [HardwareManagementController::class, 'destroyModel'])->name('hardware.models.destroy');
    Route::post('/hardware/models/bulk-delete', [HardwareManagementController::class, 'bulkDeleteModels'])->name('hardware.models.bulk-delete');

    // Sistem ayarları (sadece SuperAdmin)
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Admin yönetimi (sadece SuperAdmin)
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins.index');
});

// Single game test API (for localStorage-based testing)
Route::post('/api/test-single-game', [SystemAnalysisController::class, 'testSingleGame']);

// System data saving page (for localStorage)
Route::post('/save-system-data', function (Request $request) {
    return view('save-system-data', ['systemData' => $request->all()]);
})->name('save-system-data');

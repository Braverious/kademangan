<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RunningTextController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CoverageController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home', ['title' => 'Kelurahan Kademangan']);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');


// Grouping Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('auth/login', 'index')->name('login');
    Route::post('auth/process', 'aksi_login');

    // Rute apabila akses via GET, lemparin aja ke login lagi
    Route::get('auth/process', function () {
        return redirect()->route('login');
    });

    // Rute logout
    Route::get('logout', 'logout')->name('logout');
});

// Grouping Admin (Harus Login)
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // ================= PROFILE =================
    Route::get('/profil', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profil/update', [ProfileController::class, 'update'])->name('admin.profile.update');

    // ================= SETTINGS =================
    Route::get('/settings/footer', [SettingsController::class, 'footer'])->name('admin.settings.footer');
    Route::post('/settings/footer/save', [SettingsController::class, 'footerSave'])->name('admin.settings.footer.save');

    Route::get('/settings/runningtext', [RunningTextController::class, 'index'])->name('admin.settings.runningtext');
    Route::post('/settings/runningtext', [RunningTextController::class, 'update'])->name('admin.settings.runningtext.update');

    // ================= USER MANAGEMENT =================
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

    // ================= COVERAGE =================
    Route::get('/coverage', [CoverageController::class, 'index'])->name('admin.coverage');
    Route::post('/coverage', [CoverageController::class, 'update'])->name('admin.coverage.update');

    // ================= LAYANAN (NEW) =================
    Route::prefix('layanan')->group(function () {

        Route::get('/', [LayananController::class, 'index'])->name('admin.layanan');

        Route::get('/tambah', [LayananController::class, 'create'])->name('admin.layanan.create');
        Route::post('/store', [LayananController::class, 'store'])->name('admin.layanan.store');

        Route::get('/edit/{id}', [LayananController::class, 'edit'])->name('admin.layanan.edit');
        Route::post('/update/{id}', [LayananController::class, 'update'])->name('admin.layanan.update');

        Route::get('/delete/{id}', [LayananController::class, 'delete'])->name('admin.layanan.delete');
    });
});


// Uji coba error handling
// Route::get('/test-403', function () {
//     abort(403);
// });

// Route::get('/test-500', function () {
//     abort(500);
// });

// Route::get('/test-405', function () {
//     abort(405);
// });
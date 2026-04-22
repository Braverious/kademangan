<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RunningTextController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CoverageController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\RefJabatanController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\SuratSktmController;
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
    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');

        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');

        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('jabatan')->group(function () {
        Route::get('/', [RefJabatanController::class, 'index'])->name('admin.jabatan.index');
        Route::get('/create', [RefJabatanController::class, 'create'])->name('admin.jabatan.create');
        Route::post('/', [RefJabatanController::class, 'store'])->name('admin.jabatan.store');
        Route::get('/{id}/edit', [RefJabatanController::class, 'edit'])->name('admin.jabatan.edit');
        Route::put('/{id}', [RefJabatanController::class, 'update'])->name('admin.jabatan.update');
        Route::patch('/{id}/toggle', [RefJabatanController::class, 'toggle'])->name('admin.jabatan.toggle');
        Route::delete('/{id}', [RefJabatanController::class, 'destroy'])->name('admin.jabatan.destroy');
    });

    // ================= COVERAGE =================
    Route::get('/coverage', [CoverageController::class, 'index'])->name('admin.coverage');
    Route::post('/coverage', [CoverageController::class, 'update'])->name('admin.coverage.update');

    // ================= LAYANAN (NEW) =================
    Route::prefix('layanan')->group(function () {

        Route::get('/', [LayananController::class, 'index'])->name('admin.layanan.index');
        Route::get('/create', [LayananController::class, 'create'])->name('admin.layanan.create');
        Route::post('/', [LayananController::class, 'store'])->name('admin.layanan.store');

        Route::get('/{id}/edit', [LayananController::class, 'edit'])->name('admin.layanan.edit');
        Route::put('/{id}', [LayananController::class, 'update'])->name('admin.layanan.update');

        Route::delete('/{id}', [LayananController::class, 'destroy'])->name('admin.layanan.destroy');
    });

    // ================= PENGUMUMAN =================
    Route::prefix('pengumuman')->group(function () {

        Route::get('/', [PengumumanController::class, 'index'])->name('admin.pengumuman.index');
        Route::get('/create', [PengumumanController::class, 'create'])->name('admin.pengumuman.create');
        Route::post('/', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');

        Route::get('/{id}/edit', [PengumumanController::class, 'edit'])->name('admin.pengumuman.edit');
        Route::put('/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');

        Route::delete('/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');
    });

    // ================= GALERI =================
    Route::prefix('galeri')->group(function () {

        Route::get('/', [GaleriController::class, 'index'])->name('admin.galeri.index');

        Route::get('/create', [GaleriController::class, 'create'])->name('admin.galeri.create');
        Route::post('/', [GaleriController::class, 'store'])->name('admin.galeri.store');

        Route::get('/{id}/edit', [GaleriController::class, 'edit'])->name('admin.galeri.edit');
        Route::put('/{id}', [GaleriController::class, 'update'])->name('admin.galeri.update');

        Route::delete('/{id}', [GaleriController::class, 'destroy'])->name('admin.galeri.destroy');
    });

    // ================= BERITA =================
    Route::prefix('berita')->group(function () {

        Route::get('/', [BeritaController::class, 'index'])->name('admin.berita.index');
        Route::get('/create', [BeritaController::class, 'create'])->name('admin.berita.create');
        Route::post('/', [BeritaController::class, 'store'])->name('admin.berita.store');

        Route::post('/upload-gambar', [BeritaController::class, 'uploadGambar'])->name('admin.berita.upload-gambar');

        Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
        Route::put('/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');

        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');
    });

    // ================= SKTM =================
    Route::prefix('surat-sktm')->group(function () {

        Route::get('/', [SuratSktmController::class, 'index'])->name('admin.sktm.index');

        Route::get('/export', [SuratSktmController::class, 'export'])->name('admin.sktm.export');

        Route::get('/{id}', [SuratSktmController::class, 'detail'])->name('admin.sktm.detail');

        Route::get('/{id}/edit', [SuratSktmController::class, 'edit'])->name('admin.sktm.edit');

        Route::put('/{id}', [SuratSktmController::class, 'update'])->name('admin.sktm.update');

        Route::delete('/{id}', [SuratSktmController::class, 'destroy'])->name('admin.sktm.delete');

        Route::get('/{id}/cetak', [SuratSktmController::class, 'cetak'])->name('admin.sktm.cetak');
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
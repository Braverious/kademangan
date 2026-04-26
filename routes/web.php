<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\JangkauanController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RefJabatanController;
use App\Http\Controllers\Admin\RunningTextController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SuratBelumBekerjaController;
use App\Http\Controllers\Admin\SuratPenghasilanController;
use App\Http\Controllers\Admin\SuratSktmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FrontBeritaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Models\Jangkauan;
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
Route::get('/berita', [FrontBeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [FrontBeritaController::class, 'detail'])->name('berita.detail');

Route::post('/chatbot/send', [ChatbotController::class, 'handleChat'])->middleware('throttle:10,1');
Route::get('/admin/chatbot', [ChatbotController::class, 'adminIndex'])->name('admin.chatbot.index')->middleware('throttle:5,1');
Route::post('/admin/chatbot/update', [ChatbotController::class, 'adminUpdate'])->name('admin.chatbot.update');

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

    // ================= SETTINGS MASTER GROUP =================
    Route::prefix('pengaturan')->name('admin.settings.')->group(function () {

        // 1. Web Settings (About, Links, Social, Video)
        Route::controller(SettingsController::class)->group(function () {
            Route::get('/konfigurasi', 'settings')->name('index'); // admin.settings.index
            Route::post('/save', 'settingsSave')->name('save');    // admin.settings.save
        });

        // 2. Running Text
        Route::prefix('runningtext')->controller(RunningTextController::class)->name('runningtext.')->group(function () {
            Route::get('/', 'index')->name('index');  // admin.settings.runningtext.index
            Route::post('/', 'update')->name('update');
        });

        // 3. User Management
        Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/import', [UserController::class, 'importExcel'])->name('import');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // 4. Referensi Jabatan
        Route::prefix('jabatan')->controller(RefJabatanController::class)->name('jabatan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::patch('/{id}/toggle', 'toggle')->name('toggle');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // 5. Jangkauan Area
        Route::prefix('jangkauan')->controller(JangkauanController::class)->name('jangkauan.')->group(function () {
            Route::get('/', 'index')->name('index'); // admin.pengaturan.jangkauan.index
            Route::post('/', 'update')->name('update');
        });

        // 6. Layanan (Manajemen Kategori Layanan)
        Route::prefix('layanan')->controller(LayananController::class)->name('layanan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });
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
        Route::delete('/berita/bulk-delete', [BeritaController::class, 'bulkDestroy'])->name('admin.berita.bulkDestroy');
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

    Route::prefix('surat-belum-bekerja')->group(function () {

        Route::get('/', [SuratBelumBekerjaController::class, 'index'])->name('admin.belum-bekerja.index');

        Route::get('/export', [SuratBelumBekerjaController::class, 'export'])->name('admin.belum-bekerja.export');

        Route::get('/{id}', [SuratBelumBekerjaController::class, 'detail'])->name('admin.belum-bekerja.detail');

        Route::get('/{id}/edit', [SuratBelumBekerjaController::class, 'edit'])->name('admin.belum-bekerja.edit');

        Route::put('/{id}', [SuratBelumBekerjaController::class, 'update'])->name('admin.belum-bekerja.update');

        Route::delete('/{id}', [SuratBelumBekerjaController::class, 'destroy'])->name('admin.belum-bekerja.delete');

        Route::get('/{id}/cetak', [SuratBelumBekerjaController::class, 'cetak'])->name('admin.belum-bekerja.cetak');
    });


    Route::prefix('surat-penghasilan')->group(function () {

        Route::get('/', [SuratPenghasilanController::class, 'index'])->name('admin.penghasilan.index');

        Route::get('/export', [SuratPenghasilanController::class, 'export'])->name('admin.penghasilan.export');

        Route::get('/{id}', [SuratPenghasilanController::class, 'detail'])->name('admin.penghasilan.detail');

        Route::get('/{id}/edit', [SuratPenghasilanController::class, 'edit'])->name('admin.penghasilan.edit');

        Route::put('/{id}', [SuratPenghasilanController::class, 'update'])->name('admin.penghasilan.update');

        Route::delete('/{id}', [SuratPenghasilanController::class, 'destroy'])->name('admin.penghasilan.delete');

        Route::get('/{id}/cetak', [SuratPenghasilanController::class, 'cetak'])->name('admin.penghasilan.cetak');
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

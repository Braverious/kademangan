<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RunningTextController;
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
    // Rute Logout
    Route::get('logout', 'logout')->name('logout');
});

// Grouping Admin (Harus Login)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/profil', [ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profil/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/settings/footer', [SettingsController::class, 'footer'])->name('admin.settings.footer');
    Route::post('/settings/footer/save', [SettingsController::class, 'footerSave'])->name('admin.settings.footer.save');
    Route::get('/settings/runningtext', [RunningTextController::class, 'index'])->name('admin.settings.runningtext');
Route::post('/settings/runningtext', [RunningTextController::class, 'update'])->name('admin.settings.runningtext.update');});


// Uji coba error handling
// Route::get('/test-403', function () {
//     abort(403);
// });

// Route::get('/test-500', function () {
//     abort(500);
// });
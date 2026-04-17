<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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
    Route::get('logout', 'logout')->name('logout');
});

// Grouping Admin (Harus Login)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

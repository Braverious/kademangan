<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('home', ['title' => 'KKelurahan Kademangan']);
});

// Grouping Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('auth/login', 'index')->name('login');
    Route::post('auth/process', 'aksi_login');
    Route::get('logout', 'logout')->name('logout');
});

// Grouping Admin (Hanya bisa diakses jika sudah login)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

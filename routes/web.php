<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AdminPengaduanController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;

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
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pengaduan', AdminPengaduanController::class);
    Route::post('/pengaduan/{pengaduan}/tanggapan', [AdminPengaduanController::class, 'storeTanggapan'])->name('pengaduan.tanggapan');
    Route::patch('/pengaduan/{pengaduan}/status', [AdminPengaduanController::class, 'updateStatus'])->name('pengaduan.status');
    Route::resource('users', AdminUserController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('pengaduan', PengaduanController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

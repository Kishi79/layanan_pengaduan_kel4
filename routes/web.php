<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;

// Halaman Utama
Route::get('/', [PengaduanController::class, 'index'])->name('home');
Route::get('/pengaduans', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/pengaduans', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
Route::resource('pengaduan', PengaduanController::class);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController; // <-- Tambahkan baris ini di atas

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
});

// === TAMBAHKAN KODE INI DI BAGIAN BAWAH ===
Route::get('/tambah-menu', [MenuController::class, 'create']);
Route::post('/tambah-menu', [MenuController::class, 'store'])->name('menu.store');
// Jalur untuk melihat daftar menu
Route::get('/menu', [MenuController::class, 'index']);
// Jalur untuk fitur Edit Menu
Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
// Jalur untuk fitur Hapus Menu
Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
// Jalur untuk halaman katalog publik pelanggan
Route::get('/katalog', [MenuController::class, 'katalog']);

Route::get('/menu/setting', [MenuController::class, 'editSetting'])->name('menu.setting');
Route::post('/menu/setting', [MenuController::class, 'updateSetting'])->name('menu.updatesetting');

Route::patch('/menu/{id}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menu.toggleStatus');
Route::post('/admin/verify', [MenuController::class, 'verifyPasscode'])->name('admin.verify');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\CategoryController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [AspirasiController::class, 'siswaDashboard'])->name('siswa.dashboard');
    Route::post('/siswa/aspirasi', [AspirasiController::class, 'store'])->name('siswa.aspirasi.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AspirasiController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::put('/admin/aspirasi/{aspirasi}', [AspirasiController::class, 'update'])->name('admin.aspirasi.update');
    Route::post('/admin/kategori', [CategoryController::class, 'store'])->name('admin.kategori.store');
    Route::delete('/admin/kategori/{category}', [CategoryController::class, 'destroy'])->name('admin.kategori.destroy');
});

Route::get('/', function () {
    return redirect('/login');
});
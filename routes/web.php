<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KhoaController;
use App\Http\Controllers\Admin\LopController;
use App\Http\Controllers\Admin\MonHocController;
use App\Http\Controllers\Admin\SinhVienController;
use App\Http\Controllers\Admin\GiangVienController;
use App\Http\Controllers\Admin\DiemController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AIPredictionController;
use App\Http\Controllers\GiangVien\DashboardController as GiangVienDashboardController;
use App\Http\Controllers\GiangVien\DiemController as GiangVienDiemController;
use App\Http\Controllers\SinhVien\DashboardController as SinhVienDashboardController;
use App\Http\Controllers\SinhVien\DiemController as SinhVienDiemController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Resources
    Route::resource('khoas', KhoaController::class);
    Route::resource('lops', LopController::class);
    Route::resource('mon-hocs', MonHocController::class);
    Route::resource('sinh-viens', SinhVienController::class);
    Route::resource('giang-viens', GiangVienController::class);
    
    // Quản lý Điểm
    Route::get('diems', [DiemController::class, 'index'])->name('diems.index');
    Route::post('diems/danh-sach', [DiemController::class, 'danhSach'])->name('diems.danh-sach');
    Route::post('diems', [DiemController::class, 'store'])->name('diems.store');
    
    // AI Prediction Routes
    Route::get('ai', [AIPredictionController::class, 'index'])->name('ai.index');
    Route::post('ai/predict', [AIPredictionController::class, 'predict'])->name('ai.predict');
    Route::get('ai/students', [AIPredictionController::class, 'students'])->name('ai.students');
    Route::get('ai/risk-analysis', [AIPredictionController::class, 'riskAnalysis'])->name('ai.risk-analysis');
    Route::get('ai/history', [AIPredictionController::class, 'history'])->name('ai.history');
    Route::post('ai/save-prediction', [AIPredictionController::class, 'savePrediction'])->name('ai.save-prediction');
});

// Giảng viên Routes
Route::middleware(['auth', 'check.role:giang-vien'])->prefix('giang-vien')->name('giang-vien.')->group(function () {
    Route::get('/dashboard', [GiangVienDashboardController::class, 'index'])->name('dashboard');
    
    // Quản lý Điểm
    Route::get('diems', [GiangVienDiemController::class, 'index'])->name('diems.index');
    Route::post('diems/danh-sach', [GiangVienDiemController::class, 'danhSach'])->name('diems.danh-sach');
    Route::post('diems', [GiangVienDiemController::class, 'store'])->name('diems.store');
});

// Sinh viên Routes
Route::middleware(['auth', 'check.role:sinh-vien'])->prefix('sinh-vien')->name('sinh-vien.')->group(function () {
    Route::get('/dashboard', [SinhVienDashboardController::class, 'index'])->name('dashboard');
    
    // Xem điểm
    Route::get('diems', [SinhVienDiemController::class, 'index'])->name('diems.index');
});

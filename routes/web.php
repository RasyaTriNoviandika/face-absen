<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\FaceRecognitionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Face Recognition Public Routes (untuk karyawan absen)
Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance.page');

// Face Recognition API Routes
Route::prefix('api/face')->group(function () {
    Route::post('/register', [FaceRecognitionController::class, 'registerFace']);
    Route::get('/registered', [FaceRecognitionController::class, 'getRegisteredFaces']);
    Route::post('/check-in', [FaceRecognitionController::class, 'checkIn']);
    Route::post('/check-out', [FaceRecognitionController::class, 'checkOut']);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    Route::get('employees/{employee}/register-face', [EmployeeController::class, 'registerFacePage'])
        ->name('employees.register-face');
    
    // Attendance
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendances.show');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\User\UserAttendanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('index');
})->name('home');

// Face Recognition Public Page
Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance.page');

/*
|--------------------------------------------------------------------------
| Face Recognition API Routes (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('api/face')->group(function () {
    Route::post('/register', [FaceRecognitionController::class, 'registerFace'])
        ->name('api.face.register');
    Route::get('/registered', [FaceRecognitionController::class, 'getRegisteredFaces'])
        ->name('api.face.registered');
    Route::post('/check-in', [FaceRecognitionController::class, 'checkIn'])
        ->name('api.face.checkin');
    Route::post('/check-out', [FaceRecognitionController::class, 'checkOut'])
        ->name('api.face.checkout');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // User Attendance History
    Route::get('/user/attendance', [UserAttendanceController::class, 'index'])
        ->name('user.attendance');
    
    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Employee Management
    Route::resource('employees', EmployeeController::class);
    Route::get('/employees/{employee}/register-face', [EmployeeController::class, 'registerFace'])
        ->name('employees.register-face');

    // Attendance Management
    Route::resource('attendances', AttendanceController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
    });
});

// Auth Routes
require __DIR__.'/auth.php';
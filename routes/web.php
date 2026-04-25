<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Employee Routes
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::post('/time-in', [EmployeeController::class, 'timeIn'])->name('time-in');
    Route::post('/time-out', [EmployeeController::class, 'timeOut'])->name('time-out');
    Route::get('/my-logs', [EmployeeController::class, 'myLogs'])->name('my-logs');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/employees', [AdminController::class, 'employees'])->name('employees');
    Route::get('/employee-logs/{id}', [AdminController::class, 'employeeLogs'])->name('employee-logs');
    Route::get('/all-logs', [AdminController::class, 'allLogs'])->name('all-logs');
    Route::get('/edit-log/{id}', [AdminController::class, 'editLog'])->name('edit-log');
    Route::put('/update-log/{id}', [AdminController::class, 'updateLog'])->name('update-log');
});
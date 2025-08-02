<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

// Home route - redirect to dashboard if authenticated, otherwise show home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes (only login/logout, no registration)
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Protected routes
Route::middleware('auth')->group(function () {
    // Product routes
    Route::resource('products', ProductController::class);
    
    // Category routes
    Route::resource('categories', CategoryController::class);
    
    // Transaction routes
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{transaction}/pdf', [TransactionController::class, 'exportPDF'])->name('transactions.pdf');
    Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.excel');
    
    // Staff management (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('staff', StaffController::class);
    });
    
    // Settings (for all authenticated users)
    Route::middleware(['auth'])->group(function () {
        Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.update');
        Route::delete('/settings/delete-photo', [App\Http\Controllers\SettingsController::class, 'deletePhoto'])->name('settings.delete-photo');
    });
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'exportPDF'])->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
});

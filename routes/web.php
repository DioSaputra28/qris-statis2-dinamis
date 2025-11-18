<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrisController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Public routes (accessible by anyone)
Route::get('/qris/{uniqueId}', [TransactionController::class, 'showQris'])->name('qris.public');

// Guest routes (accessible without login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated routes (require login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/transactions-export', [TransactionController::class, 'export'])->name('transactions.export');
    
    // API Keys
    Route::get('/api-keys', [App\Http\Controllers\ApiKeyController::class, 'index'])->name('api-keys.index');
    Route::post('/api-keys', [App\Http\Controllers\ApiKeyController::class, 'store'])->name('api-keys.store');
    Route::delete('/api-keys/{id}', [App\Http\Controllers\ApiKeyController::class, 'destroy'])->name('api-keys.destroy');
    
    // QRIS Settings
    Route::get('/settings', [QrisController::class, 'index'])->name('settings.index');
    Route::post('/qris', [QrisController::class, 'store'])->name('qris.store');
    Route::put('/qris/{id}', [QrisController::class, 'update'])->name('qris.update');
    Route::delete('/qris/{id}', [QrisController::class, 'destroy'])->name('qris.destroy');
    
    // Documentation
    Route::get('/documentation', function () {
        return view('documentation.index');
    })->name('documentation.index');
});

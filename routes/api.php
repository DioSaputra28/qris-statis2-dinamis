<?php

use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// API routes with API key validation
Route::middleware('api.key')->group(function () {
    // Create transaction and return link
    Route::post('/transactions/create-link', [TransactionController::class, 'createLink']);
    
    // Create transaction and return QR code as base64
    Route::post('/transactions/create-qrcode', [TransactionController::class, 'createQrCode']);
});

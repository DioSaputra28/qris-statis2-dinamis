<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('admin.dashboard');
})->name('login.post');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/transactions', function () {
    return view('transactions.index');
})->name('transactions.index');

Route::get('/api-keys', function () {
    return view('apiKeys.index');
})->name('api-keys.index');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings.index');

Route::get('/documentation', function () {
    return view('documentation.index');
})->name('documentation.index');

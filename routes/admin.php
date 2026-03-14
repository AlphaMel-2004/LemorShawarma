<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('admin.login.submit');

Route::middleware(['auth', 'admin.user'])->name('admin.')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['create', 'show']);

    Route::get('contacts', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('contacts', [ContactController::class, 'update'])->name('contacts.update');
});

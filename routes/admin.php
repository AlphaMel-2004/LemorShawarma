<?php

use App\Http\Controllers\Admin\ChatbotSettingsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LegalSettingsController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('admin.login.submit');

Route::middleware(['auth', 'admin.user'])->name('admin.')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class)->except(['create', 'show']);
    Route::resource('locations', LocationController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->only(['index', 'update', 'destroy']);

    Route::get('chatbot', [ChatbotSettingsController::class, 'edit'])->name('chatbot.edit');
    Route::put('chatbot', [ChatbotSettingsController::class, 'update'])->name('chatbot.update');

    Route::get('contacts', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('contacts', [ContactController::class, 'update'])->name('contacts.update');

    Route::get('legal', [LegalSettingsController::class, 'edit'])->name('legal.edit');
    Route::put('legal', [LegalSettingsController::class, 'update'])->name('legal.update');
});

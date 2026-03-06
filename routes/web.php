<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/menu', [\App\Http\Controllers\MobileMenuController::class, 'index'])->name('mobile.menu');
Route::post('/menu/feedback', [\App\Http\Controllers\MobileMenuController::class, 'storeFeedback'])->name('mobile.feedback');

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth');

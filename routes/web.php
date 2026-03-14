<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [MenuController::class, 'index'])->name('products');

Route::get('/menu', [\App\Http\Controllers\MobileMenuController::class, 'index'])->name('mobile.menu');
Route::post('/menu/feedback', [\App\Http\Controllers\MobileMenuController::class, 'storeFeedback'])->name('mobile.feedback');
Route::post('/menu/order', [\App\Http\Controllers\MobileMenuController::class, 'storeOrder'])->name('mobile.order');

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');

Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth');

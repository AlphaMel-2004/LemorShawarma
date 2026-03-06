<?php

use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class)->except(['create', 'show']);

Route::get('contacts', [ContactController::class, 'edit'])->name('contacts.edit');
Route::put('contacts', [ContactController::class, 'update'])->name('contacts.update');

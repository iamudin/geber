<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AdminMiddleware;

Route::prefix('admin')->middleware(['auth',AdminMiddleware::class])->prefix('admin')->group(function(){
    Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('admin.dashboard');
    Route::resource('/category', CategoryController::class);

    });

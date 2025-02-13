<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
Route::prefix('admin')->middleware(['auth'])->prefix('admin')->group(function(){
    Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('admin.dashboard');
    Route::resource('/category', CategoryController::class);

    });

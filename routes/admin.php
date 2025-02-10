<?php
use Illuminate\Support\Facades\Route;
Route::middleware(['auth',App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function(){
    Route::get('/', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('products', App\Livewire\Admin\Products\Index::class)->name('admin.products.index');
    Route::get('members', App\Livewire\Admin\Members\Index::class)->name('admin.members.index');
    Route::get('pages', App\Livewire\Admin\Pages\Index::class)->name('admin.pages.index');
    Route::get('banners', App\Livewire\Admin\Banners\Index::class)->name('admin.banners.index');

    });

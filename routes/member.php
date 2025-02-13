<?php

use App\Http\Middleware\MemberMiddleware;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth',MemberMiddleware::class])->group(function(){
    Route::get('dashboard', App\Livewire\Member\Home::class)->name('member.dashboard');
    Route::get('category', App\Livewire\Member\Category::class)->name('member.category');
    Route::get('product', App\Livewire\Member\Products\Index::class)->name('member.products.index');
    });

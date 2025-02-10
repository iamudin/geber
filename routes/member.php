<?php

use Illuminate\Support\Facades\Route;
Route::middleware('auth')->group(function(){
    Route::get('dashboard', App\Livewire\Member\Home::class)->name('member.dashboard');
    Route::get('product', App\Livewire\Member\Products\Index::class)->name('member.products.index');
    });

<?php
use Illuminate\Support\Facades\Route;
Route::domain(main_url())->middleware('guest')->group(function(){
    Route::get('login/{type?}', [App\Http\Controllers\AuthController::class,'login'])->name('login');
    Route::post('login/{type?}', [App\Http\Controllers\AuthController::class,'login']);
    Route::match(['get','post'],'join-{referal}', [App\Http\Controllers\AuthController::class,'register'])->name('register');
});
Route::domain(main_url())->match(['get','post'],'logout', [App\Http\Controllers\AuthController::class,'logout'])->name('logout');

<?php

use App\Http\Controllers\Api\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Auth\ApiBaseController;
Route::match(['post','get','delete'],'login',[ApiBaseController::class,'login']);
Route::match(['post','get','delete'],'register',[ApiBaseController::class,'register']);
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('user/logged',[UserController::class,'logged']);
    Route::prefix('supplier')->group(function(){
        Route::post('register',[SupplierController::class,'register']);
        Route::get('profile',[SupplierController::class,'profile']);
    });
    Route::match(['post','get'],'file/destroy', [FileController::class, 'destroy']);
    Route::post('user/logout',[UserController::class,'logout']);
});



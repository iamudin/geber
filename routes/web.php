<?php

use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Jobs\OtpSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebBaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', [WebBaseController::class,'verifyEmail'])->name('verification.verify');
Route::get('/', function () {
    return view('cooming');
});
Route::get('/verify', function (Request $request) {
    $user = User::find(1);
    $user->notify(new App\Http\Controllers\Auth\VerifyEmail);

})->middleware('auth');

Route::get('/login', function (Request $request) {
 return 'login form';
})->name('login');


<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class WebBaseController extends Controller
{

    public function verifyEmail(Request $request, $id, $hash)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);
        if (! $request->hasValidSignature()) {
            return 'Link has expired or is invalid.';
        }
        // Verifikasi hash
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return 'Invalid verification link.';
        }

        // Jika email sudah diverifikasi sebelumnya
        if ($user->hasVerifiedEmail()) {
            return 'Email already verified';
        }

        // Tandai email sebagai terverifikasi
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return "email Berhasil verifikasi";
    }
    function dashboard(Request $request){

        // return to_route('home');
    }
    public function cross_login($session){
        $user = User::whereActiveSession($session)->first();
        if($user){
            Auth::login($user);
            return to_route('member.home');
        }
        return to_route('home');

    }
}

<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;



class VerifyEmail extends \Illuminate\Auth\Notifications\VerifyEmail

{

    protected function verificationUrl($notifiable)

    {

        $expiration = now()->addSeconds(10)->timestamp; // Sesuaikan durasi (60 menit)
            return URL::temporarySignedRoute(
                'verification.verify',
                $expiration,
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

    }

}

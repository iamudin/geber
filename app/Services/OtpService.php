<?php

namespace App\Services;
use Ichtrojan\Otp\Otp;
use App\Jobs\OtpSender;

class OtpService
{

    function generate($indetifier){
        $phonenumber = convertToInternational($indetifier);
        $genereate_token = (new Otp)->generate($phonenumber, 'numeric', config('geber.otp.length'), config('geber.otp.validity'));
        OtpSender::dispatch($phonenumber,$genereate_token->token)->onQueue('default');

    }
    function validate($indetifier,$otp)
    {
            $phonenumber = convertToInternational($indetifier);
            return (new Otp)->validate($phonenumber, $otp);
    }

}

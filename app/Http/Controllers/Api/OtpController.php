<?php

namespace App\Http\Controllers\Api;
use Ichtrojan\Otp\Otp;
use App\Jobs\OtpSender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtpController extends Controller
{

    function generate(Request $request)
    {
        if($request->isMethod('get')){
            abort(403);
        }

        if($request->isMethod('post')){
            return response()->json(['status'=>true,'message'=>'Generate OTP Success']);
        }

    }
    function generateOtp($request){
        $phonenumber = convertToInternational($request->phonenumber);
        $genereate_token = (new Otp)->generate($phonenumber, 'numeric', config('geber.otp.length'), config('geber.otp.validity'));
        OtpSender::dispatch($phonenumber,$genereate_token->token)->onQueue('default');

    }
    function validate(Request $request)
    {
        if($request->isMethod('get')){
            abort(403);
        }

        if($request->isMethod('post')){
            $phonenumber = convertToInternational($request->phonenumber);
            $otp = $request->token;
            return (new Otp)->validate($phonenumber, $otp);
        }

    }
}

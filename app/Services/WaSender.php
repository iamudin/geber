<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

 class WaSender
{
    function __construct(protected string $phone, protected string $token)
    {
        $data = Http::get(config('geber.api_wa'),[
            'message'=>' Kode OTP anda '.$this->token,
            'to'=>$this->phone,
        ]);
        if(!$data->successful()){
            new WaSender($this->phone,$this->token);
        }
    }
}

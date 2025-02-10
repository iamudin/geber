<?php
return  [
    'api_url' => env('GEBER_API_URL','http://localhost'),
    'storage_url' => env('GEBER_STORAGE_URL','http://localhost'),
    'member_url' => env('GEBER_MEMBER_URL','http://localhost'),
    'otp' => [
        'validity'=> 2,
        'length'=> 6,
    ],
    'api_wa' => env('GEBER_API_WA','http://localhost'),
];

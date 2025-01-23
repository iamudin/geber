<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{

    function __invoke(Request $request)
    {
        if($request->isMethod('get')){
            abort(403);
        }
        if($request->isMethod('post')){

        }
    }
}

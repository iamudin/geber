<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function index(Request $request){
        if(Auth::check()){
            $role = $request->user()->role;
            if($role=='member'){
                return to_route('member.dashboard');

            }
            if($role =='admin'){
                return to_route('admin.dashboard');
            }
        }
        return view('home.index');
    }
}

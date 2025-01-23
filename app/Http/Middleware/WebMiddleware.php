<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class WebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!in_array(request()->ip(), [':::1','127.0.0.1'])){
            if(Route::currentRouteName() == 'login' && $request->getHost() == api_url()){
                return response()->json(['code'=>'403','status'=>'User Unauthorized']);
            }
            abort_if( $request->is('/') && $request->getHost() == api_url(),'404');

            if($request->segment(1) == 'api' || Route::currentRouteName() == 'stream' ){
                abort_if($request->segment(1) == 'api' && $request->getHost() != api_url(),'404','Not Found');
                abort_if(  Route::currentRouteName() == 'stream' && $request->getHost() != api_url() && !auth()->check(),'404','Not Found');
            }

        return $next($request);
    }
}
}

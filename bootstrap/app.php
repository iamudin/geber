<?php

use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\WebMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SanctumMiddleware;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\SanctumAuthMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->alias([
        //     'panel' => Panel::class
        // ]);
        $middleware->web(append: [
            WebMiddleware::class,
        ]);

        $middleware->api(prepend: [
            ApiMiddleware::class
        ]);
    })
  ->withExceptions(function (Exceptions $exceptions) {

})
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (AuthenticationException $e, Request $request) {
        if($request->getHost()==api_url()){
            return response()->json(['error'=>'Unauthorized'],401);
        }

    });
})
->create();

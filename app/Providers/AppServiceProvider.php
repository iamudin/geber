<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once(__DIR__ . "/../Inc/Helpers.php");
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}

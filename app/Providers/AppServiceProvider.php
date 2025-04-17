<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    $this->app->singleton(LoginResponse::class, LoginResponse::class);

    Inertia::share([
        'auth' => fn () => [
            'user' => Auth::user(),
        ],

        // Share flash messages globally
        'flash' => fn () => [
            'success' => Session::get('success'),
            'fee' => Session::get('fee'),
            'duration_minutes' => Session::get('duration_minutes'),
        ],
    ]);
}
}

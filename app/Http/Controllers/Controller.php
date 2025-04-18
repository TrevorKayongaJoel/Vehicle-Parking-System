<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

abstract class Controller
{
    public function boot()
{
    Inertia::share([
        'auth.user' => function () {
            return Auth::user();
        },
    ]);
}
}

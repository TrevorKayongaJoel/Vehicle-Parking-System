<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;

use App\Http\Controllers\Admin\UserController;

use App\Http\Middleware\AdminMiddleware;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match($user->role) {
            'admin' => Inertia::render('AdminDashboard'),
            'attendant' => Inertia::render('AttendantDashboard'),
            default => abort(403),
        };
    })->name('dashboard');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin-dashboard', fn () => Inertia::render('Admin/Dashboard'))
        ->name('admin.dashboard');
});

// Route::get('/admin/users', function () {
//     $users = \App\Models\User::all();
//     return Inertia::render('Admin/Users', [
//         'users' => $users,
//     ]);
// })->middleware(['auth', 'admin'])->name('admin.users');



Route::middleware(['auth'])->group(function () {
    Route::get('/attendant/parking', [ParkingController::class, 'index'])->name('parking.index');
    Route::post('/attendant/check-in', [ParkingController::class, 'checkIn'])->name('parking.checkin');
});



// Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':admin'])->prefix('admin')->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('admin.users');
// });


// Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

// Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':admin'])
//     ->prefix('admin')
//     ->group(function () {
//         Route::get('/users', [UserController::class, 'index'])->name('admin.users');
//         Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update'); // ← Add this
//     });

Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });




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

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'attendant' => redirect()->route('attendant.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');
});

Route::middleware(['auth', 'verified', \App\Http\Middleware\RoleMiddleware::class . ':attendant'])->group(function () {
    Route::get('/attendant-dashboard', fn () => Inertia::render('AttendantDashboard'))
        ->name('attendant.dashboard');
});
Route::middleware(['auth', 'verified', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin-dashboard', fn () => Inertia::render('AdminDashboard'))
        ->name('admin.dashboard');
});



require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin-dashboard', fn () => Inertia::render('AdminDashboard'))
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
        // //AdminDashboard
        // Route::get('/dashboard', function() {
        //     if (auth()->user()->role !== 'admin') {
        //         abort(403);
        //     }
        //     return Inertia::render('AdminDashboard');
        // })->name('dashboard');
        // //UserManagement
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':attendant'])
    ->prefix('attendant')
    ->group(function () {
        // // AttendantDashboard
        // Route::get('/dashboard', function() {
        //     if (auth()->user()->role !== 'attendant') {
        //         abort(403);
        //     }
        //     return Inertia::render('AttendantDashboard');
        // })->name('dashboard');
        // // Parking Management

        Route::get('/parking', [ParkingController::class, 'index'])->name('parking.index');
        Route::post('/check-in', [ParkingController::class, 'checkIn'])->name('parking.checkin');
        Route::post('/check-out/{parking}', [ParkingController::class, 'checkOut'])->name('parking.checkout');
        Route::post('/attendant/check-out', [ParkingController::class, 'checkOut'])->name('parking.checkout');
    });



    

    

  





<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;
use Illuminate\Support\Carbon;
use App\Models\ParkingRecord;
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
    Route::get('/attendant-dashboard', function () {
        $slots = \App\Models\ParkingSlot::all();
        return Inertia::render('AttendantDashboard', [
            'slots' => $slots,
        ]);
    })->name('attendant.dashboard');
});

Route::get('/admin-dashboard', function () {
    $today = \Carbon\Carbon::today();

    $todayCheckins = \App\Models\ParkingRecord::whereDate('check_in_time', $today)->count();
    $todayRevenue = \App\Models\ParkingRecord::whereDate('check_out_time', $today)->sum('fee');

    $todayRevenue = round(\App\Models\ParkingRecord::whereDate('check_out_time', $today)->sum('fee'));


    return Inertia::render('AdminDashboard', [
        'todayCheckins' => $todayCheckins,
        'todayRevenue' => $todayRevenue,
    ]);
})->middleware(['auth', 'verified', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->name('admin.dashboard');




require __DIR__.'/auth.php';





Route::middleware(['auth'])->group(function () {
    Route::get('/attendant/parking', [ParkingController::class, 'index'])->name('parking.index');
    Route::post('/attendant/check-in', [ParkingController::class, 'checkIn'])->name('parking.checkin');
});





Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class.':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
   
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':attendant'])
    ->prefix('attendant')
    ->group(function () {
        Route::get('/parking', [ParkingController::class, 'index'])->name('parking.index');
        Route::post('/check-in', [ParkingController::class, 'checkIn'])->name('parking.checkin');
    });

// RESTful route outside group
Route::post('/parking/checkout', [ParkingController::class, 'checkOut'])->name('parking.checkout');


use App\Http\Controllers\PaymentController;


Route::middleware(['auth'])->group(function () {
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/store', [PaymentController::class, 'store'])->name('payments.store');
});

Route::get('/admin/reports', [\App\Http\Controllers\Admin\ParkingReportController::class, 'index'])
    ->name('admin.reports');


    Route::middleware(['auth'])->get('/admin/dashboard-summary', function () 
        {
        $today = \Carbon\Carbon::today();
    
        return response()->json([
            'todayCheckins' => \App\Models\ParkingRecord::whereDate('check_in_time', $today)->count(),
            'todayRevenue' => \App\Models\ParkingRecord::whereDate('check_out_time', $today)->sum('fee'),
        ]);
    });

    

    Route::get('/admin/daily-fees', function () {
        $records = ParkingRecord::whereNotNull('check_out_time')
            ->whereDate('check_out_time', '>=', Carbon::now()->subDays(7))
            ->orderBy('check_out_time')
            ->get()
            ->groupBy(fn($r) => Carbon::parse($r->check_out_time)->toDateString())
            ->map(fn($group) => $group->sum('fee'));
    
        return response()->json([
            'dates' => $records->keys()->values(),
            'fees' => $records->values()->map(fn($fee) => round($fee)),
        ]);
    });
    




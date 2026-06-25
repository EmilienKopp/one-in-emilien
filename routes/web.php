<?php

use App\Http\Controllers\OssController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Public routes (portfolio)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Route::get('/dev', function () {
//     return Inertia::render('Dev/Index');
// })->name('dev');

Route::prefix('dev')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dev/Index');
    })->name('dev.index');

    Route::get('/showcase', function () {
        return Inertia::render('Dev/Showcase');
    })->name('dev.showcase');
});

if (! app()->isProduction()) {
    Route::get('/dev/snippets', function () {
        return Inertia::render('Dev/Snippets');
    })->name('dev.snippets');
}

Route::prefix('oss')->group(function () {
    Route::get('/', [OssController::class, 'index'])->name('oss.index');
    Route::get('/{package}', [OssController::class, 'show'])->name('oss.show');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/privacy', function () {
    return Inertia::render('Privacy');
})->name('privacy');

// Admin routes (protected)
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    // Availability management will be added in Phase 3
    // Route::get('/availability', [AvailabilityController::class, 'index'])->name('admin.availability');
});

// Legacy dashboard route - redirect to admin
Route::get('dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';

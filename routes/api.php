<?php

use App\Http\Controllers\Api\EmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Contact form email submission
Route::post('/email', [EmailController::class, 'send'])->name('api.email.send');

// Chat endpoints (to be implemented in Phase 4)
// Route::post('/chat', [ChatController::class, 'message'])->name('api.chat.message');

// Site data endpoints (to be implemented in Phase 4)
// Route::get('/site', [SiteController::class, 'show'])->name('api.site.show');
// Route::post('/site', [SiteController::class, 'update'])->name('api.site.update');

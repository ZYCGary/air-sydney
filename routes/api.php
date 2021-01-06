<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('api.')->group(function () {
    // Register
    Route::post('register', [AuthController::class, 'register'])->name('register');

    // Login
    Route::post('login', [AuthController::class, 'login'])->name('login');

    // Get specific user profile
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    // Routes for logged-in user
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {

        // Logout
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // Get current user profile
        Route::get('user', [UserController::class, 'me'])->name('user.show');

        // Update user profile
        Route::post('user', [UserController::class, 'update'])->name('user.update');
    });
});


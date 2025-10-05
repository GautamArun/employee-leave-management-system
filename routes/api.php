<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// protected routes
Route::middleware('auth')->group(function() {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    // employee only routes
    Route::middleware('role:employee')->group(function() {
        Route::get('employee/dashboard', fn() => response()->json(['message' => 'employee dashboard']));
    });

    // admin only routes
    Route::middleware('role:admin')->group(function() {
        Route::get('admin/dashboard', fn() => response()->json(['message' => 'admin dashboard']));
    });
});
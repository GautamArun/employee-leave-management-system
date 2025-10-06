<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveRequestController;
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
        Route::get('leaves', [LeaveRequestController::class, 'index']);
        Route::post('leaves', [LeaveRequestController::class, 'store']);
        Route::put('leaves/{id}', [LeaveRequestController::class, 'update']);
        Route::delete('leaves/{id}', [LeaveRequestController::class, 'destroy']);
    });

    // admin only routes
    Route::middleware('role:admin')->group(function() {
        Route::patch('admin/leaves/{id}/status', [LeaveRequestController::class, 'updateStatus']);
    });
});
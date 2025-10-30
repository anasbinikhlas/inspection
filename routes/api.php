<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes
Route::get('/check-availability', [AppointmentController::class, 'checkAvailability']);
Route::get('/available-slots', [AppointmentController::class, 'getAvailableSlots']);
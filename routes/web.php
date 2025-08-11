<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminInspectorController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminInspectionController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', function () {
    return view('public.home');
})->name('home');

// Appointment Routes
Route::prefix('appointment')->group(function () {
    Route::get('/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/confirmation/{appointmentNumber}', [AppointmentController::class, 'confirmation'])->name('appointment.confirmation');
    Route::match(['GET', 'POST'], '/check-status', [AppointmentController::class, 'checkStatus'])->name('appointment.check-status');
    Route::get('/reschedule/{appointmentNumber}', [AppointmentController::class, 'reschedule'])->name('appointment.reschedule');
    Route::post('/reschedule/{appointmentNumber}', [AppointmentController::class, 'updateReschedule'])->name('appointment.update-reschedule');
    // In routes/web.php or api.php
    Route::get('/api/check-availability', [AppointmentController::class, 'checkAvailability']);
});

// API Routes for AJAX
Route::prefix('api')->group(function () {
    Route::get('/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('api.available-slots');
});

// Contact form
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Appointments Management
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [AdminAppointmentController::class, 'index'])->name('index');
        Route::get('/create', [AdminAppointmentController::class, 'create'])->name('create');
        Route::post('/', [AdminAppointmentController::class, 'store'])->name('store');
        Route::get('/{appointment}', [AdminAppointmentController::class, 'show'])->name('show');
        Route::get('/{appointment}/edit', [AdminAppointmentController::class, 'edit'])->name('edit');
        Route::put('/{appointment}', [AdminAppointmentController::class, 'update'])->name('update');
        Route::delete('/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('destroy');
        Route::post('/{appointment}/confirm', [AdminAppointmentController::class, 'confirm'])->name('confirm');
        Route::post('/{appointment}/cancel', [AdminAppointmentController::class, 'cancel'])->name('cancel');
        Route::post('/{appointment}/assign-inspector', [AdminAppointmentController::class, 'assignInspector'])->name('assign-inspector');
    });
    
    // Inspections Management
    Route::prefix('inspections')->name('inspections.')->group(function () {
        Route::get('/', [AdminInspectionController::class, 'index'])->name('index');
        Route::get('/create/{appointment}', [AdminInspectionController::class, 'create'])->name('create');
        Route::post('/', [AdminInspectionController::class, 'store'])->name('store');
        Route::get('/{inspection}', [AdminInspectionController::class, 'show'])->name('show');
        Route::get('/{inspection}/edit', [AdminInspectionController::class, 'edit'])->name('edit');
        Route::put('/{inspection}', [AdminInspectionController::class, 'update'])->name('update');
        Route::delete('/{inspection}', [AdminInspectionController::class, 'destroy'])->name('destroy');
        Route::get('/{inspection}/pdf', [AdminInspectionController::class, 'generatePDF'])->name('pdf');
    });
    
    // Customers Management
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [AdminCustomerController::class, 'index'])->name('index');
        Route::get('/create', [AdminCustomerController::class, 'create'])->name('create');
        Route::post('/', [AdminCustomerController::class, 'store'])->name('store');
        Route::get('/{customer}', [AdminCustomerController::class, 'show'])->name('show');
        Route::get('/{customer}/edit', [AdminCustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [AdminCustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [AdminCustomerController::class, 'destroy'])->name('destroy');
    });
    
    // Inspectors Management
    Route::prefix('inspectors')->name('inspectors.')->group(function () {
        Route::get('/', [AdminInspectorController::class, 'index'])->name('index');
        Route::get('/create', [AdminInspectorController::class, 'create'])->name('create');
        Route::post('/', [AdminInspectorController::class, 'store'])->name('store');
        Route::get('/{inspector}', [AdminInspectorController::class, 'show'])->name('show');
        Route::get('/{inspector}/edit', [AdminInspectorController::class, 'edit'])->name('edit');
        Route::put('/{inspector}', [AdminInspectorController::class, 'update'])->name('update');
        Route::delete('/{inspector}', [AdminInspectorController::class, 'destroy'])->name('destroy');
        Route::get('/{inspector}/schedule', [AdminInspectorController::class, 'schedule'])->name('schedule');
    });
    
    // Locations Management
    Route::prefix('locations')->name('locations.')->group(function () {
        Route::get('/', [AdminLocationController::class, 'index'])->name('index');
        Route::get('/create', [AdminLocationController::class, 'create'])->name('create');
        Route::post('/', [AdminLocationController::class, 'store'])->name('store');
        Route::get('/{location}', [AdminLocationController::class, 'show'])->name('show');
        Route::get('/{location}/edit', [AdminLocationController::class, 'edit'])->name('edit');
        Route::put('/{location}', [AdminLocationController::class, 'update'])->name('update');
        Route::delete('/{location}', [AdminLocationController::class, 'destroy'])->name('destroy');
    });
    
    // Reports & Analytics
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings');
});

/*
|--------------------------------------------------------------------------
| Inspector Routes
|--------------------------------------------------------------------------
*/

Route::prefix('inspector')->name('inspector.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('inspector.dashboard');
    })->name('dashboard');
    
    Route::get('/inspections', function () {
        return view('inspector.inspections.index');
    })->name('inspections.index');
    
    Route::get('/inspections/{inspection}/perform', function () {
        return view('inspector.inspections.perform');
    })->name('inspections.perform');
});

// Authentication Routes
require __DIR__.'/auth.php';
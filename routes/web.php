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
use App\Http\Controllers\InspectionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', function () {
    return view('public.home');
})->name('home');

// Public pages
Route::get('/about', function () {
    return view('public.about');
})->name('about');

Route::get('/services', function () {
    return view('public.services');
})->name('services');

Route::get('/pricing', function () {
    return view('public.pricing');
})->name('pricing');

Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');

// Appointment Routes
Route::prefix('appointment')->group(function () {
    Route::get('/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/confirmation/{appointmentNumber}', [AppointmentController::class, 'confirmation'])->name('appointment.confirmation');
    Route::match(['GET', 'POST'], '/check-status', [AppointmentController::class, 'checkStatus'])->name('appointment.check-status');
    Route::get('/reschedule/{appointmentNumber}', [AppointmentController::class, 'reschedule'])->name('appointment.reschedule');
    Route::post('/reschedule/{appointmentNumber}', [AppointmentController::class, 'updateReschedule'])->name('appointment.update-reschedule');
});

// API Routes for AJAX
Route::prefix('api')->group(function () {
    Route::get('/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('api.available-slots');
});

// Contact form
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Authentication routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Admin login redirect
Route::get('/admin/login', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    
    // Appointments Management
    Route::resource('appointments', AdminAppointmentController::class);
    Route::post('/appointments/{appointment}/confirm', [AdminAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{appointment}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{appointment}/assign-inspector', [AdminAppointmentController::class, 'assignInspector'])->name('appointments.assign-inspector');
    
    // Inspections Management
    Route::resource('inspections', AdminInspectionController::class);
    Route::get('/inspections/create/{appointment}', [AdminInspectionController::class, 'create'])->name('inspections.create-from-appointment');
    Route::get('/inspections/{inspection}/pdf', [AdminInspectionController::class, 'generatePDF'])->name('inspections.pdf');
    
    // Customers Management
    Route::resource('customers', AdminCustomerController::class);
    
    // Inspectors Management
    Route::resource('inspectors', AdminInspectorController::class);
    Route::get('/inspectors/{inspector}/schedule', [AdminInspectorController::class, 'schedule'])->name('inspectors.schedule');
    
    // Locations Management
    Route::resource('locations', AdminLocationController::class);
    
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
    
    // Inspector Inspections
    Route::get('/inspections', [InspectionController::class, 'index'])->name('inspections.index');
    Route::get('/inspections/{inspection}', [InspectionController::class, 'show'])->name('inspections.show');
    Route::get('/inspections/{inspection}/step/{step}', [InspectionController::class, 'step'])->name('inspections.step');
    Route::post('/inspections/{inspection}/step/{step}', [InspectionController::class, 'saveStep'])->name('inspections.save-step');
    Route::post('/inspections/{inspection}/upload-photo', [InspectionController::class, 'uploadPhoto'])->name('inspections.upload-photo');
});

/*
|--------------------------------------------------------------------------
| Inspection Routes (Shared between Admin & Inspector)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Inspection routes
    Route::get('/inspections', [InspectionController::class, 'index'])->name('inspections.index');
    Route::get('/inspections/create', [InspectionController::class, 'create'])->name('inspections.create');
    Route::post('/inspections', [InspectionController::class, 'store'])->name('inspections.store');
    Route::get('/inspections/{inspection}', [InspectionController::class, 'show'])->name('inspections.show');
    Route::get('/inspections/{inspection}/edit', [InspectionController::class, 'edit'])->name('inspections.edit');
    Route::get('/inspections/{inspection}/step/{step}', [InspectionController::class, 'step'])->name('inspections.step');
    Route::post('/inspections/{inspection}/step/{step}', [InspectionController::class, 'saveStep'])->name('inspections.save-step');
    Route::post('/inspections/{inspection}/upload-photo', [InspectionController::class, 'uploadPhoto'])->name('inspections.upload-photo');
    Route::get('/inspections/{inspection}/pdf', [InspectionController::class, 'generatePDF'])->name('inspections.pdf');
    Route::get('/inspections/{inspection}/preview', [InspectionController::class, 'preview'])->name('inspections.preview');
    Route::delete('/inspections/{inspection}', [InspectionController::class, 'destroy'])->name('inspections.destroy');
});

/*
|--------------------------------------------------------------------------
| Fallback Dashboard Route
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'inspector') {
            return redirect()->route('inspector.dashboard');
        }
    }
    return redirect()->route('login');
})->name('dashboard');

// Authentication Routes (Laravel Breeze/UI)
require __DIR__.'/auth.php';
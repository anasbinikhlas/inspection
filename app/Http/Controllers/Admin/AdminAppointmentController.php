<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Models\Inspection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Inspector;
use App\Models\Location;
use Carbon\Carbon;

class AdminAppointmentController extends Controller
{
    /**
     * Display a listing of appointments
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['customer', 'inspector', 'location', 'inspection']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('appointment_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('appointment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        // Source filter
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Get appointments with pagination
        $appointments = $query->orderBy('appointment_date', 'desc')
                              ->orderBy('appointment_time', 'desc')
                              ->paginate(15)
                              ->withQueryString();

        // Get status counts for statistics cards
        $statusCounts = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'in_progress' => Appointment::where('status', 'in_progress')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        // Get active inspectors for modal
        $inspectors = Inspector::where('status', 'active')->get();

        return view('admin.appointments.index', compact('appointments', 'statusCounts', 'inspectors'));
    }

    // REMOVED: create() method - not needed anymore
    // REMOVED: store() method - not needed anymore

    /**
     * Display the specified appointment
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['customer', 'inspector', 'location', 'inspection']);
        
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment
     */
    public function edit(Appointment $appointment)
    {
        $customers = Customer::where('status', 'active')->orderBy('first_name')->get();
        $inspectors = Inspector::where('status', 'active')->get();
        $locations = Location::where('status', 'active')->get();

        return view('admin.appointments.edit', compact('appointment', 'customers', 'inspectors', 'locations'));
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'location_id' => 'required|exists:locations,id',
            'inspector_id' => 'nullable|exists:inspectors,id',
            'vehicle_make' => 'required|string|max:100',
            'vehicle_model' => 'required|string|max:100',
            'vehicle_year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'vehicle_type' => 'required|string',
            'vin' => 'nullable|string|max:17',
            'license_plate' => 'nullable|string',
            'mileage' => 'nullable|integer',
            'color' => 'nullable|string',
            'package_type' => 'required|in:basic,complete,premium',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,no_show,rescheduled',
            'customer_notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Update price if package changed
        if ($appointment->package_type !== $validated['package_type']) {
            $packages = [
                'basic' => ['price' => 99.00, 'duration' => 90],
                'complete' => ['price' => 199.00, 'duration' => 120],
                'premium' => ['price' => 299.00, 'duration' => 150]
            ];
            $packageInfo = $packages[$validated['package_type']];
            $validated['price'] = $packageInfo['price'];
            $validated['estimated_duration'] = $packageInfo['duration'];
        }

        $appointment->update($validated);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified appointment
     */
    public function destroy(Appointment $appointment)
    {
        // Check if appointment can be deleted
        if ($appointment->inspection) {
            return back()->with('error', 'Cannot delete appointment with an existing inspection.');
        }

        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }

    /**
     * Confirm an appointment
     */
    public function confirm(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be confirmed.');
        }

        $appointment->update(['status' => 'confirmed']);

        return back()->with('success', 'Appointment confirmed successfully!');
    }

    /**
     * Cancel an appointment
     */
    public function cancel(Appointment $appointment)
    {
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully!');
    }

/**
 * Assign inspector to appointment and auto-create inspection
 */
public function assignInspector(Request $request, Appointment $appointment)
{
    $request->validate([
        'inspector_id' => 'required|exists:inspectors,id'
    ]);

    // Check if inspector is available at this time
    $conflict = Appointment::where('inspector_id', $request->inspector_id)
        ->where('appointment_date', $appointment->appointment_date)
        ->where('appointment_time', $appointment->appointment_time)
        ->where('id', '!=', $appointment->id)
        ->whereNotIn('status', ['cancelled', 'no_show'])
        ->exists();

    if ($conflict) {
        return back()->with('error', 'This inspector is already assigned to another appointment at this time.');
    }

    DB::beginTransaction();
    try {
        // Update appointment with inspector
        $appointment->update(['inspector_id' => $request->inspector_id]);

// Auto-create inspection if not exists
// Auto-create inspection if not exists
// Auto-create inspection if not exists
if (!$appointment->inspection) {
    $inspection = Inspection::create([
        'inspection_number' => Inspection::generateInspectionNumber(),
        'appointment_id' => $appointment->id,
        'inspector_id' => $request->inspector_id,
        'status' => 'in_progress',  // Changed from 'pending'
        'overall_condition' => 'good',
        'recommendation' => 'buy',
        'started_at' => now(),  // Set start time
    ]);
}

        DB::commit();

        return back()->with('success', 'Inspector assigned and inspection created successfully!');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to assign inspector: ' . $e->getMessage());
    }
}
}
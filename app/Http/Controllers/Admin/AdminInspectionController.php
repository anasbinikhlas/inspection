<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Appointment;
use App\Models\Inspector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminInspectionController extends Controller
{
    /**
     * Display a listing of inspections
     */
    public function index(Request $request)
    {
        $query = Inspection::with(['appointment.customer', 'appointment.location', 'inspector']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by inspector
        if ($request->filled('inspector_id')) {
            $query->where('inspector_id', $request->inspector_id);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('overall_condition', $request->condition);
        }

        // Filter by recommendation
        if ($request->filled('recommendation')) {
            $query->where('recommendation', $request->recommendation);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by inspection number or vehicle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('inspection_number', 'like', "%{$search}%")
                  ->orWhereHas('appointment', function($q) use ($search) {
                      $q->where('vehicle_make', 'like', "%{$search}%")
                        ->orWhere('vehicle_model', 'like', "%{$search}%")
                        ->orWhere('appointment_number', 'like', "%{$search}%");
                  });
            });
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $inspections = $query->paginate(20)->withQueryString();

        // Get filter options
        $inspectors = Inspector::active()->get();
        
        $stats = [
            'total' => Inspection::count(),
            'in_progress' => Inspection::where('status', 'in_progress')->count(),
            'completed' => Inspection::where('status', 'completed')->count(),
            'avg_score' => Inspection::avg('overall_score') ?? 0
        ];

        return view('admin.inspections.index', compact('inspections', 'inspectors', 'stats'));
    }

    /**
     * Show the form for creating a new inspection
     */
    public function create(Appointment $appointment)
    {
        // Check if inspection already exists for this appointment
        if ($appointment->inspection) {
            return redirect()->route('admin.inspections.edit', $appointment->inspection)
                           ->with('info', 'Inspection already exists for this appointment.');
        }

        // Check if appointment is confirmed or in progress
        if (!in_array($appointment->status, ['confirmed', 'in_progress'])) {
            return redirect()->back()
                           ->with('error', 'Cannot create inspection. Appointment must be confirmed or in progress.');
        }

        $inspectors = Inspector::active()->get();
        
        return view('admin.inspections.create', compact('appointment', 'inspectors'));
    }

    /**
     * Store a newly created inspection
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'inspector_id' => 'required|exists:inspectors,id',
            'overall_condition' => 'required|in:excellent,good,fair,poor,needs_attention',
            'recommendation' => 'required|in:buy,negotiate,avoid,minor_repairs,major_repairs',
            'engine_transmission_score' => 'nullable|numeric|min:0|max:100',
            'brakes_score' => 'nullable|numeric|min:0|max:100',
            'suspension_steering_score' => 'nullable|numeric|min:0|max:100',
            'interior_score' => 'nullable|numeric|min:0|max:100',
            'ac_heater_score' => 'nullable|numeric|min:0|max:100',
            'electrical_score' => 'nullable|numeric|min:0|max:100',
            'exterior_body_score' => 'nullable|numeric|min:0|max:100',
            'tyres_score' => 'nullable|numeric|min:0|max:100',
            'frame_score' => 'nullable|numeric|min:0|max:100',
            'test_drive_score' => 'nullable|numeric|min:0|max:100',
            'immediate_repairs_cost' => 'nullable|numeric|min:0',
            'future_maintenance_cost' => 'nullable|numeric|min:0',
            'estimated_value' => 'nullable|numeric|min:0',
            'summary' => 'nullable|string',
            'major_issues' => 'nullable|string',
            'minor_issues' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'inspector_notes' => 'nullable|string',
            'test_drive_performed' => 'boolean',
            'test_drive_distance' => 'nullable|integer|min:0',
            'test_drive_notes' => 'nullable|string',
            'status' => 'required|in:in_progress,completed'
        ]);

        DB::beginTransaction();
        try {
            // Generate inspection number
            $validated['inspection_number'] = Inspection::generateInspectionNumber();
            $validated['started_at'] = now();
            
            if ($validated['status'] === 'completed') {
                $validated['completed_at'] = now();
            }

            // Create inspection
            $inspection = Inspection::create($validated);

            // Calculate overall score
            $inspection->overall_score = $inspection->calculateOverallScore();
            $inspection->save();

            // Update appointment status
            $appointment = Appointment::find($validated['appointment_id']);
            if ($validated['status'] === 'completed') {
                $appointment->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
            } else {
                $appointment->update([
                    'status' => 'in_progress',
                    'started_at' => $appointment->started_at ?? now()
                ]);
            }

            DB::commit();

            return redirect()->route('admin.inspections.show', $inspection)
                           ->with('success', 'Inspection created successfully!');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create inspection: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified inspection
     */
    public function show(Inspection $inspection)
    {
        $inspection->load(['appointment.customer', 'appointment.location', 'inspector', 'items', 'photos']);
        
        return view('admin.inspections.show', compact('inspection'));
    }

    /**
     * Show the form for editing the specified inspection
     */
    public function edit(Inspection $inspection)
    {
        $inspection->load(['appointment', 'inspector']);
        $inspectors = Inspector::active()->get();
        
        return view('admin.inspections.edit', compact('inspection', 'inspectors'));
    }

    /**
     * Update the specified inspection
     */
    public function update(Request $request, Inspection $inspection)
    {
        $validated = $request->validate([
            'inspector_id' => 'required|exists:inspectors,id',
            'overall_condition' => 'required|in:excellent,good,fair,poor,needs_attention',
            'recommendation' => 'required|in:buy,negotiate,avoid,minor_repairs,major_repairs',
            'engine_transmission_score' => 'nullable|numeric|min:0|max:100',
            'brakes_score' => 'nullable|numeric|min:0|max:100',
            'suspension_steering_score' => 'nullable|numeric|min:0|max:100',
            'interior_score' => 'nullable|numeric|min:0|max:100',
            'ac_heater_score' => 'nullable|numeric|min:0|max:100',
            'electrical_score' => 'nullable|numeric|min:0|max:100',
            'exterior_body_score' => 'nullable|numeric|min:0|max:100',
            'tyres_score' => 'nullable|numeric|min:0|max:100',
            'frame_score' => 'nullable|numeric|min:0|max:100',
            'test_drive_score' => 'nullable|numeric|min:0|max:100',
            'immediate_repairs_cost' => 'nullable|numeric|min:0',
            'future_maintenance_cost' => 'nullable|numeric|min:0',
            'estimated_value' => 'nullable|numeric|min:0',
            'summary' => 'nullable|string',
            'major_issues' => 'nullable|string',
            'minor_issues' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'inspector_notes' => 'nullable|string',
            'test_drive_performed' => 'boolean',
            'test_drive_distance' => 'nullable|integer|min:0',
            'test_drive_notes' => 'nullable|string',
            'status' => 'required|in:in_progress,completed,reviewed,delivered'
        ]);

        DB::beginTransaction();
        try {
            // Update timestamps based on status changes
            if ($validated['status'] === 'completed' && !$inspection->completed_at) {
                $validated['completed_at'] = now();
            }
            if ($validated['status'] === 'reviewed' && !$inspection->reviewed_at) {
                $validated['reviewed_at'] = now();
            }
            if ($validated['status'] === 'delivered' && !$inspection->delivered_at) {
                $validated['delivered_at'] = now();
            }

            $inspection->update($validated);

            // Recalculate overall score
            $inspection->overall_score = $inspection->calculateOverallScore();
            $inspection->save();

            // Update appointment status if inspection is completed
            if ($validated['status'] === 'completed' && $inspection->appointment->status !== 'completed') {
                $inspection->appointment->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('admin.inspections.show', $inspection)
                           ->with('success', 'Inspection updated successfully!');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update inspection: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified inspection
     */
    public function destroy(Inspection $inspection)
    {
        try {
            $appointmentId = $inspection->appointment_id;
            $inspection->delete();

            // Reset appointment status
            Appointment::find($appointmentId)->update([
                'status' => 'confirmed',
                'completed_at' => null
            ]);

            return redirect()->route('admin.inspections.index')
                           ->with('success', 'Inspection deleted successfully!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete inspection: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF report for inspection
     */
    public function generatePDF(Inspection $inspection)
    {
        $inspection->load(['appointment.customer', 'appointment.location', 'inspector', 'items', 'photos']);
        
        $pdf = Pdf::loadView('admin.inspections.pdf', compact('inspection'));
        
        $filename = 'inspection-' . $inspection->inspection_number . '.pdf';
        
        return $pdf->download($filename);
    }
}
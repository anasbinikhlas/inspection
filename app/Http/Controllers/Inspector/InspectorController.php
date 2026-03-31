<?php

namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Appointment;
use App\Models\Inspector;
use Illuminate\Support\Facades\Auth;

class InspectorController extends Controller
{
    /**
     * Inspector Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $inspector = Inspector::where('user_id', $user->id)->firstOrFail();
        
        // Get stats for inspector
        $totalInspections = Inspection::where('inspector_id', $inspector->id)->count();
        $inProgressCount = Inspection::where('inspector_id', $inspector->id)
            ->where('status', 'in_progress')
            ->count();
        $completedCount = Inspection::where('inspector_id', $inspector->id)
            ->where('status', 'completed')
            ->count();
        $pendingReviewCount = Inspection::where('inspector_id', $inspector->id)
            ->where('status', 'completed')
            ->count();
        
        // Get recent inspections
        $recentInspections = Inspection::where('inspector_id', $inspector->id)
            ->with('appointment')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('inspector.dashboard', compact(
            'totalInspections',
            'inProgressCount',
            'completedCount',
            'pendingReviewCount',
            'recentInspections'
        ));
    }

    /**
     * List all inspections assigned to this inspector
     */
    public function inspections()
    {
        $user = Auth::user();
        $inspector = Inspector::where('user_id', $user->id)->firstOrFail();
        
        $inspections = Inspection::where('inspector_id', $inspector->id)
            ->with('appointment.customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('inspector.inspections.index', compact('inspections'));
    }

    /**
     * Perform/Fill Inspection Form
     */
    public function perform($inspectionId)
    {
        $user = Auth::user();
        $inspector = Inspector::where('user_id', $user->id)->firstOrFail();
        
        // Get inspection and verify it belongs to this inspector
        $inspection = Inspection::where('id', $inspectionId)
            ->where('inspector_id', $inspector->id)
            ->with('appointment.customer')
            ->firstOrFail();
        
        return view('inspector.inspections.perform', compact('inspection'));
    }

    /**
     * Store/Update Inspection Data
     */
    public function submitInspection($inspectionId)
    {
        $user = Auth::user();
        $inspector = Inspector::where('user_id', $user->id)->firstOrFail();
        
        // Get inspection and verify it belongs to this inspector
        $inspection = Inspection::where('id', $inspectionId)
            ->where('inspector_id', $inspector->id)
            ->firstOrFail();
        
        // Validate input
        $validated = request()->validate([
            'engine_score' => 'required|integer|between:1,10',
            'brakes_score' => 'required|integer|between:1,10',
            'transmission_score' => 'required|integer|between:1,10',
            'suspension_score' => 'required|integer|between:1,10',
            'electrical_score' => 'required|integer|between:1,10',
            'tires_score' => 'required|integer|between:1,10',
            'overall_condition' => 'required|in:excellent,good,fair,poor',
            'major_issues' => 'nullable|string',
            'minor_issues' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'repair_cost' => 'nullable|numeric|min:0',
            'parts_cost' => 'nullable|numeric|min:0',
            'test_drive_notes' => 'nullable|string',
        ]);
        
        // Calculate overall score
        $overallScore = round(
            (($validated['engine_score'] + $validated['brakes_score'] + $validated['suspension_score'] + $validated['electrical_score'] + $validated['tires_score']) / 50) * 100,
            2
        );

        // Update inspection
        $inspection->update([
            'engine_transmission_score' => $validated['engine_score'],
            'brakes_score' => $validated['brakes_score'],
            'suspension_steering_score' => $validated['suspension_score'],
            'electrical_score' => $validated['electrical_score'],
            'tyres_score' => $validated['tires_score'],
            'overall_condition' => $validated['overall_condition'],
            'overall_score' => $overallScore,
            'major_issues' => $validated['major_issues'],
            'minor_issues' => $validated['minor_issues'],
            'recommendations' => $validated['recommendations'],
            'immediate_repairs_cost' => $validated['repair_cost'],
            'test_drive_notes' => $validated['test_drive_notes'],
            'status' => 'reviewed',
            'reviewed_at' => now(),
        ]);
        
        return redirect()->route('inspector.inspections.index')
            ->with('success', 'Inspection submitted successfully for review!');
    }
}
<?php

namespace App\Http\Controllers\Inspector;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\InspectionPhoto;
use App\Models\Appointment;
use App\Models\Inspector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            ->with(['appointment.customer', 'photos'])
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
        // dd(request()->all());
        // Validate input
        $validated = request()->validate([
            'engine_score' => 'required|integer|between:1,10',
            'brakes_score' => 'required|integer|between:1,10',
            'suspension_steering_score' => 'required|integer|between:1,10',
            'interior_score' => 'required|integer|between:1,10',
            'ac_heater_score' => 'required|integer|between:1,10',
            'electrical_score' => 'required|integer|between:1,10',
            'exterior_body_score' => 'required|integer|between:1,10',
            'tyres_score' => 'required|integer|between:1,10',
            'frame_score' => 'required|integer|between:1,10',
            'test_drive_score' => 'required|integer|between:1,10',
            'overall_condition' => 'required|in:excellent,good,fair,poor,needs_attention',
            'major_issues' => 'nullable|string',
            'minor_issues' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'immediate_repairs_cost' => 'nullable|numeric|min:0',
            'future_maintenance_cost' => 'nullable|numeric|min:0',
            'test_drive_notes' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:png,jpg,jpeg,gif|max:10240',
        ]);
        
        // Calculate overall score (average of all 10 scores, out of 10)
        $scores = [
            $validated['engine_score'],
            $validated['brakes_score'],
            $validated['suspension_steering_score'],
            $validated['interior_score'],
            $validated['ac_heater_score'],
            $validated['electrical_score'],
            $validated['exterior_body_score'],
            $validated['tyres_score'],
            $validated['frame_score'],
            $validated['test_drive_score'],
        ];
        $overallScore = round(array_sum($scores) / count($scores), 2);

        // Update inspection
        $inspection->update([
            'engine_transmission_score' => $validated['engine_score'],
            'brakes_score' => $validated['brakes_score'],
            'suspension_steering_score' => $validated['suspension_steering_score'],
            'interior_score' => $validated['interior_score'],
            'ac_heater_score' => $validated['ac_heater_score'],
            'electrical_score' => $validated['electrical_score'],
            'exterior_body_score' => $validated['exterior_body_score'],
            'tyres_score' => $validated['tyres_score'],
            'frame_score' => $validated['frame_score'],
            'test_drive_score' => $validated['test_drive_score'],
            'overall_condition' => $validated['overall_condition'],
            'overall_score' => $overallScore,
            'major_issues' => $validated['major_issues'],
            'minor_issues' => $validated['minor_issues'],
            'recommendations' => $validated['recommendations'],
            'immediate_repairs_cost' => $validated['immediate_repairs_cost'],
            'future_maintenance_cost' => $validated['future_maintenance_cost'],
            'test_drive_notes' => $validated['test_drive_notes'],
            'status' => 'reviewed',
            'reviewed_at' => now(),
        ]);

        // Handle photo uploads
        if (request()->hasFile('photos')) {
            foreach (request()->file('photos') as $photo) {
                $path = $photo->store('inspection-photos/' . $inspection->id, 'public');
                
                $inspection->photos()->create([
                    'filename' => basename($path),
                    'original_filename' => $photo->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $photo->getMimeType(),
                    'file_size' => $photo->getSize(),
                    'category'  => 'inspection_photo',
                ]);
            }
        }
        
        return redirect()->route('inspector.inspections.index')
            ->with('success', 'Inspection submitted successfully for review!');
    }
}
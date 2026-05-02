<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inspector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminInspectorController extends Controller
{
    /**
     * Display a listing of inspectors
     */
    public function index(Request $request)
    {
        $query = Inspector::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('employee_id', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        $inspectors = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => Inspector::count(),
            'active' => Inspector::where('status', 'active')->count(),
            'inactive' => Inspector::where('status', 'inactive')->count(),
        ];

        return view('admin.inspectors.index', compact('inspectors', 'stats'));
    }

    /**
     * Show the form for creating a new inspector
     */
    public function create()
    {
        return view('admin.inspectors.create');
    }

    /**
     * Store a newly created inspector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:50|unique:inspectors,employee_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:inspectors,email',
            'identity_card' => 'nullable|string|max:50',
            'residence_address' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            // Create corresponding user account FIRST
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'] ?? 'inspector-' . time() . '@inspection.local',
                'password' => bcrypt('password123'), // Default password
                'role' => 'inspector',
            ]);

            // Create inspector linked to user
            $inspector = Inspector::create([
                'user_id' => $user->id,
                'employee_id' => $validated['employee_id'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? $user->email,  // Use user email as fallback
                'identity_card' => $validated['identity_card'],
                'residence_address' => $validated['residence_address'],
                'marital_status' => $validated['marital_status'],
                'status' => $validated['status'],
                'license_expiry' => now()->addYears(2),
                'hire_date' => now(),
                'hourly_rate' => 50.00,
            ]);

            DB::commit();

            return redirect()->route('admin.inspectors.show', $inspector)
                           ->with('success', 'Inspector created successfully! Login email: ' . $user->email . ' Password: password123');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create inspector: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified inspector
     */
    public function show(Inspector $inspector)
    {
        $inspector->load('user');
        
        return view('admin.inspectors.show', compact('inspector'));
    }

    /**
     * Show the form for editing the specified inspector
     */
    public function edit(Inspector $inspector)
    {
        return view('admin.inspectors.edit', compact('inspector'));
    }

    /**
     * Update the specified inspector
     */
    public function update(Request $request, Inspector $inspector)
    {
        $validated = $request->validate([
            'employee_id' => 'required|string|max:50|unique:inspectors,employee_id,' . $inspector->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:inspectors,email,' . $inspector->id,
            'identity_card' => 'nullable|string|max:50',
            'residence_address' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            // Update inspector
            $inspector->update($validated);

            // Update user account name if it exists
            if ($inspector->user) {
                $inspector->user->update([
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email' => $validated['email'] ?? $inspector->user->email,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.inspectors.show', $inspector)
                           ->with('success', 'Inspector updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update inspector: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified inspector
     */
    public function destroy(Inspector $inspector)
    {
        try {
            // Check if inspector has appointments
            if ($inspector->appointments()->exists()) {
                return redirect()->back()
                               ->with('error', 'Cannot delete inspector with active appointments.');
            }

            // Delete user account
            if ($inspector->user) {
                $inspector->user->delete();
            }

            // Delete inspector
            // Delete inspector
            $inspector->delete();

            return redirect()->route('admin.inspectors.index')
                           ->with('success', 'Inspector deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete inspector: ' . $e->getMessage());
        }
    }
}
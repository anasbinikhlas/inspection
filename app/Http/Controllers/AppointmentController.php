<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Inspector;
use App\Models\Location;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['customer', 'inspector', 'location'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $locations = Location::where('status', 'active')->get();
        $inspectors = Inspector::where('status', 'active')->get();
        
        return view('appointment.schedule', compact('locations', 'inspectors'));
    }

    public function confirmation($reference)
    {
        $appointment = Appointment::where('booking_reference', $reference)
            ->with(['location', 'inspector'])
            ->firstOrFail();
        
        return view('appointment.confirmation', compact('appointment'));
    }

    public function checkStatus()
    {
        return view('appointment.check-status');
    }

    public function getStatus(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'phone' => 'required|string'
        ]);

        $appointment = Appointment::where('booking_reference', $request->reference)
            ->where('customer_phone', $request->phone)
            ->with(['location', 'inspector', 'inspection'])
            ->first();

        if (!$appointment) {
            return back()->withErrors(['reference' => 'No appointment found with these details.']);
        }

        return view('appointment.status', compact('appointment'));
    }

    public function show($id)
    {
        $appointment = Appointment::with(['customer', 'inspector', 'location', 'inspection'])
            ->findOrFail($id);
        
        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $inspectors = Inspector::where('status', 'active')->get();
        $locations = Location::where('status', 'active')->get();
        
        return view('appointments.edit', compact('appointment', 'inspectors', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'inspector_id' => 'required|exists:inspectors,id',
            'location_id' => 'required|exists:locations,id',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:today',
            'location_id' => 'required|exists:locations,id'
        ]);

        $date = $request->date;
        $locationId = $request->location_id;

        // Get available inspectors for this location
        $availableInspectors = Inspector::where('location_id', $locationId)
            ->where('status', 'active')
            ->count();

        // Get booked appointments for this date and location
        $bookedSlots = Appointment::where('appointment_date', $date)
            ->where('location_id', $locationId)
            ->count();

        // Define working hours (9 AM to 6 PM = 9 slots per inspector)
        $slotsPerInspector = 9;
        $totalAvailableSlots = $availableInspectors * $slotsPerInspector;
        $availableSlots = $totalAvailableSlots - $bookedSlots;

        // Generate available time slots
        $timeSlots = [];
        if ($availableSlots > 0) {
            $startTime = Carbon::createFromFormat('H:i', '09:00');
            for ($i = 0; $i < $slotsPerInspector; $i++) {
                $timeSlot = $startTime->copy()->addHours($i)->format('H:i');
                
                // Check if this specific time slot is available
                $slotBooked = Appointment::where('appointment_date', $date)
                    ->where('location_id', $locationId)
                    ->where('appointment_time', $timeSlot)
                    ->count();
                
                if ($slotBooked < $availableInspectors) {
                    $timeSlots[] = [
                        'time' => $timeSlot,
                        'display' => $startTime->copy()->addHours($i)->format('g:i A')
                    ];
                }
            }
        }

        return response()->json([
            'available' => $availableSlots > 0,
            'available_slots' => $availableSlots,
            'time_slots' => $timeSlots,
            'message' => $availableSlots > 0 
                ? "Great! We have {$availableSlots} slots available on this date."
                : 'Sorry, no slots available on this date. Please choose another date.'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'vehicle_make' => 'required|string|max:100',
            'vehicle_model' => 'required|string|max:100',
            'vehicle_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'location_id' => 'required|exists:locations,id',
            'service_type' => 'required|in:basic,comprehensive,premium'
        ]);

        // Find available inspector
        $inspector = Inspector::where('location_id', $request->location_id)
            ->where('status', 'active')
            ->whereNotIn('id', function($query) use ($request) {
                $query->select('inspector_id')
                    ->from('appointments')
                    ->where('appointment_date', $request->appointment_date)
                    ->where('appointment_time', $request->appointment_time);
            })
            ->first();

        if (!$inspector) {
            return back()->withErrors(['appointment_time' => 'This time slot is no longer available.']);
        }

        $appointment = Appointment::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'vehicle_make' => $request->vehicle_make,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_year' => $request->vehicle_year,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'location_id' => $request->location_id,
            'inspector_id' => $inspector->id,
            'service_type' => $request->service_type,
            'status' => 'scheduled',
            'booking_reference' => 'INS-' . strtoupper(uniqid())
        ]);

        // Send confirmation email/SMS here if needed

        return redirect()->route('appointment.confirmation', $appointment->booking_reference)
            ->with('success', 'Appointment booked successfully!');
    }

    public function calendar()
    {
        $appointments = Appointment::with(['customer', 'inspector', 'location'])
            ->where('appointment_date', '>=', now())
            ->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->customer_name . ' - ' . $appointment->vehicle_make,
                'start' => $appointment->appointment_date . 'T' . $appointment->appointment_time,
                'end' => $appointment->appointment_date . 'T' . 
                    Carbon::createFromFormat('H:i', $appointment->appointment_time)->addHour()->format('H:i'),
                'backgroundColor' => $this->getStatusColor($appointment->status),
                'extendedProps' => [
                    'customer' => $appointment->customer_name,
                    'phone' => $appointment->customer_phone,
                    'vehicle' => $appointment->vehicle_make . ' ' . $appointment->vehicle_model,
                    'inspector' => $appointment->inspector->name ?? 'TBD',
                    'location' => $appointment->location->name ?? 'TBD',
                    'status' => $appointment->status
                ]
            ];
        });

        return view('appointments.calendar', compact('events'));
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'scheduled' => '#3B82F6',
            'in_progress' => '#F59E0B',
            'completed' => '#10B981',
            'cancelled' => '#EF4444',
            default => '#6B7280'
        };
    }

    public function getTimeSlots(Request $request)
    {
        $date = $request->date;
        $locationId = $request->location_id;

        $timeSlots = [];
        $startTime = Carbon::createFromFormat('H:i', '09:00');
        
        for ($i = 0; $i < 9; $i++) {
            $timeSlot = $startTime->copy()->addHours($i)->format('H:i');
            
            $availableInspectors = Inspector::where('location_id', $locationId)
                ->where('status', 'active')
                ->whereNotIn('id', function($query) use ($date, $timeSlot) {
                    $query->select('inspector_id')
                        ->from('appointments')
                        ->where('appointment_date', $date)
                        ->where('appointment_time', $timeSlot);
                })
                ->count();

            if ($availableInspectors > 0) {
                $timeSlots[] = [
                    'value' => $timeSlot,
                    'display' => $startTime->copy()->addHours($i)->format('g:i A'),
                    'available' => true
                ];
            }
        }

        return response()->json($timeSlots);
    }
}
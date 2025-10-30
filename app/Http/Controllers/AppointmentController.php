<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Inspector;
use App\Models\Location;
use App\Models\Customer;
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
        
        // Define packages
        $packages = [
            'basic' => [
                'name' => 'Basic Inspection',
                'price' => 99,
                'duration' => 90
            ],
            'complete' => [
                'name' => 'Complete Inspection',
                'price' => 199,
                'duration' => 120
            ],
            'premium' => [
                'name' => 'Premium Inspection',
                'price' => 299,
                'duration' => 150
            ]
        ];
        
        $selectedPackage = 'complete'; // Default
        $prefilledData = [];
        
        return view('appointment.schedule', compact('locations', 'inspectors', 'packages', 'selectedPackage', 'prefilledData'));
    }

    public function confirmation($appointmentNumber)
    {
        $appointment = Appointment::where('appointment_number', $appointmentNumber)
            ->with(['location', 'inspector', 'customer'])
            ->firstOrFail();
        
        return view('appointment.confirmation', compact('appointment'));
    }

    public function checkStatus(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('appointment.check-status');
        }

        $request->validate([
            'appointment_number' => 'required|string',
            'phone' => 'required|string'
        ]);

        $appointment = Appointment::where('appointment_number', $request->appointment_number)
            ->whereHas('customer', function($query) use ($request) {
                $query->where('phone', $request->phone);
            })
            ->with(['location', 'inspector', 'inspection', 'customer'])
            ->first();

        if (!$appointment) {
            return back()->withErrors(['appointment_number' => 'No appointment found with these details.']);
        }

        return view('appointment.status', compact('appointment'));
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'location_id' => 'required|exists:locations,id'
        ]);

        $date = $request->date;
        $locationId = $request->location_id;

        // Get time slots
        $timeSlots = $this->getDefaultTimeSlots($date, $locationId);

        return response()->json([
            'available' => count($timeSlots) > 0,
            'available_slots' => count($timeSlots),
            'time_slots' => $timeSlots,
            'slots' => $timeSlots, // For frontend compatibility
            'message' => count($timeSlots) > 0 
                ? "Great! We have " . count($timeSlots) . " slots available on this date."
                : 'Sorry, no slots available on this date. Please choose another date.'
        ]);
    }

    private function getDefaultTimeSlots($date, $locationId)
    {
        // Default time slots
        $baseSlots = [
            ['time' => '09:00', 'value' => '09:00', 'display' => '9:00 AM'],
            ['time' => '10:00', 'value' => '10:00', 'display' => '10:00 AM'],
            ['time' => '11:00', 'value' => '11:00', 'display' => '11:00 AM'],
            ['time' => '12:00', 'value' => '12:00', 'display' => '12:00 PM'],
            ['time' => '14:00', 'value' => '14:00', 'display' => '2:00 PM'],
            ['time' => '15:00', 'value' => '15:00', 'display' => '3:00 PM'],
            ['time' => '16:00', 'value' => '16:00', 'display' => '4:00 PM'],
            ['time' => '17:00', 'value' => '17:00', 'display' => '5:00 PM']
        ];

        $availableSlots = [];
        foreach ($baseSlots as $slot) {
            $bookedCount = Appointment::where('appointment_date', $date)
                ->where('location_id', $locationId)
                ->where('appointment_time', $slot['time'])
                ->count();

            // Allow max 5 appointments per time slot
            if ($bookedCount < 5) {
                $availableSlots[] = $slot;
            }
        }

        return $availableSlots;
    }

    public function store(Request $request)
    {
        // Detect which form is being submitted
        $isHeroForm = $request->has('customer_name'); // Hero form sends customer_name
        $isScheduleForm = $request->has('first_name'); // Schedule form sends first_name
        
        if ($isHeroForm) {
            // HERO FORM VALIDATION (Simple quick booking)
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_email' => 'nullable|email|max:255',
                'vehicle_make' => 'required|string|max:100',
                'vehicle_model' => 'required|string|max:100',
                'vehicle_year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'location_id' => 'required|exists:locations,id',
                'service_type' => 'required|in:basic,comprehensive,premium,complete'
            ]);

            // Split the customer name into first and last name
            $nameParts = explode(' ', trim($request->customer_name), 2);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
            
            $vehicleType = 'sedan'; // Default for hero form
            
        } else {
            // SCHEDULE FORM VALIDATION (Detailed booking)
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'zip_code' => 'nullable|string',
                'vehicle_make' => 'required|string|max:100',
                'vehicle_model' => 'required|string|max:100',
                'vehicle_year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
                'vehicle_type' => 'required|string',
                'mileage' => 'nullable|integer',
                'color' => 'nullable|string',
                'vin' => 'nullable|string|max:17',
                'license_plate' => 'nullable|string',
                'package_type' => 'required|in:basic,complete,premium',
                'location_id' => 'required|exists:locations,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'customer_notes' => 'nullable|string'
            ]);
            
            $firstName = $request->first_name;
            $lastName = $request->last_name;
            $vehicleType = $request->vehicle_type;
        }

        // Determine phone and email
        $phone = $isHeroForm ? $request->customer_phone : $request->phone;
        $email = $isHeroForm 
            ? ($request->customer_email ?? 'noemail' . time() . '@example.com')
            : $request->email;

        // Create or update customer
        $customer = Customer::updateOrCreate(
            ['phone' => $phone],
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'address' => $request->address ?? null,
                'city' => $request->city ?? null,
                'zip_code' => $request->zip_code ?? null,
                'status' => 'active'
            ]
        );

        // Find available inspector
        $inspector = Inspector::where('status', 'active')
            ->whereNotIn('id', function($query) use ($request) {
                $query->select('inspector_id')
                    ->from('appointments')
                    ->where('appointment_date', $request->appointment_date)
                    ->where('appointment_time', $request->appointment_time)
                    ->whereNotNull('inspector_id');
            })
            ->first();

        // Map service_type/package_type to database ENUM
        $serviceType = $isHeroForm ? $request->service_type : $request->package_type;
        $packageTypeMapping = [
            'basic' => 'basic',
            'comprehensive' => 'complete',
            'complete' => 'complete',
            'premium' => 'premium'
        ];
        
        $packageType = $packageTypeMapping[$serviceType];

        // Package pricing and duration
        $packages = [
            'basic' => ['price' => 99.00, 'duration' => 90],
            'complete' => ['price' => 199.00, 'duration' => 120],
            'premium' => ['price' => 299.00, 'duration' => 150]
        ];

        $packageInfo = $packages[$packageType];

        // Create the appointment
        $appointment = Appointment::create([
            'appointment_number' => Appointment::generateAppointmentNumber(),
            'customer_id' => $customer->id,
            'location_id' => $request->location_id,
            'inspector_id' => $inspector ? $inspector->id : null,
            'vehicle_make' => $request->vehicle_make,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_year' => $request->vehicle_year,
            'vehicle_type' => $vehicleType,
            'vin' => $request->vin ?? null,
            'license_plate' => $request->license_plate ?? null,
            'mileage' => $request->mileage ?? null,
            'color' => $request->color ?? null,
            'package_type' => $packageType,
            'price' => $packageInfo['price'],
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'estimated_duration' => $packageInfo['duration'],
            'status' => 'pending',
            'customer_notes' => $request->customer_notes ?? null
        ]);

        // Redirect to confirmation page
        return redirect()->route('appointment.confirmation', $appointment->appointment_number)
            ->with('success', 'Appointment booked successfully! Your appointment number is ' . $appointment->appointment_number);
    }

    public function getAvailableSlots(Request $request)
    {
        return $this->checkAvailability($request);
    }

    // Additional methods for rescheduling
    public function reschedule($appointmentNumber)
    {
        $appointment = Appointment::where('appointment_number', $appointmentNumber)
            ->with(['customer', 'location', 'inspector'])
            ->firstOrFail();
        
        $locations = Location::where('status', 'active')->get();
        
        return view('appointment.reschedule', compact('appointment', 'locations'));
    }

    public function updateReschedule(Request $request, $appointmentNumber)
    {
        $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'location_id' => 'required|exists:locations,id',
        ]);

        $appointment = Appointment::where('appointment_number', $appointmentNumber)
            ->firstOrFail();

        // Find any available inspector
        $inspector = Inspector::where('status', 'active')
            ->whereNotIn('id', function($query) use ($request) {
                $query->select('inspector_id')
                    ->from('appointments')
                    ->where('appointment_date', $request->appointment_date)
                    ->where('appointment_time', $request->appointment_time)
                    ->whereNotNull('inspector_id');
            })
            ->first();

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'location_id' => $request->location_id,
            'inspector_id' => $inspector ? $inspector->id : $appointment->inspector_id,
            'status' => 'rescheduled'
        ]);

        return redirect()->route('appointment.confirmation', $appointment->appointment_number)
            ->with('success', 'Appointment rescheduled successfully!');
    }
}
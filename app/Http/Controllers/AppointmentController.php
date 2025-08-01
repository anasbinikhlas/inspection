<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Inspector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function create(Request $request)
    {
        $locations = Location::active()->get();
        
        // Get pricing based on package
        $packages = [
            'basic' => ['name' => 'Basic Inspection', 'price' => 99],
            'complete' => ['name' => 'Complete Inspection', 'price' => 199],
            'premium' => ['name' => 'Premium Plus', 'price' => 299]
        ];

        $selectedPackage = $request->get('package', 'complete');
        $prefilledData = [
            'vehicle_type' => $request->get('vehicle_type'),
            'location' => $request->get('location'),
            'preferred_date' => $request->get('preferred_date'),
            'package' => $selectedPackage
        ];

        return view('appointment.create', compact('locations', 'packages', 'selectedPackage', 'prefilledData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            
            'vehicle_make' => 'required|string|max:255',
            'vehicle_model' => 'required|string|max:255',
            'vehicle_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'vehicle_type' => 'required|string|in:sedan,suv,hatchback,truck,motorcycle,van,coupe',
            'vin' => 'nullable|string|max:17',
            'license_plate' => 'nullable|string|max:10',
            'mileage' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
            
            'location_id' => 'required|exists:locations,id',
            'package_type' => 'required|in:basic,complete,premium',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|string',
            'customer_notes' => 'nullable|string|max:1000'
        ]);

        DB::beginTransaction();
        try {
            // Create or find customer
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'zip_code' => $validated['zip_code']
                ]
            );

            // Get package pricing
            $packagePricing = [
                'basic' => 99,
                'complete' => 199,
                'premium' => 299
            ];

            // Check availability
            $appointmentDateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
            $isAvailable = $this->checkAvailability($validated['location_id'], $appointmentDateTime);
            
            if (!$isAvailable) {
                return back()->withErrors(['appointment_time' => 'This time slot is not available.'])->withInput();
            }

            // Create appointment
            $appointment = Appointment::create([
                'appointment_number' => Appointment::generateAppointmentNumber(),
                'customer_id' => $customer->id,
                'location_id' => $validated['location_id'],
                'vehicle_make' => $validated['vehicle_make'],
                'vehicle_model' => $validated['vehicle_model'],
                'vehicle_year' => $validated['vehicle_year'],
                'vehicle_type' => $validated['vehicle_type'],
                'vin' => $validated['vin'],
                'license_plate' => $validated['license_plate'],
                'mileage' => $validated['mileage'],
                'color' => $validated['color'],
                'package_type' => $validated['package_type'],
                'price' => $packagePricing[$validated['package_type']],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'customer_notes' => $validated['customer_notes'],
                'status' => 'pending'
            ]);

            DB::commit();

            // Send confirmation email (implement later)
            // $this->sendConfirmationEmail($appointment);

            return redirect()->route('appointment.confirmation', $appointment->appointment_number)
                           ->with('success', 'Your appointment has been successfully scheduled!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function confirmation($appointmentNumber)
    {
        $appointment = Appointment::with(['customer', 'location'])
                                 ->where('appointment_number', $appointmentNumber)
                                 ->firstOrFail();

        return view('appointment.confirmation', compact('appointment'));
    }

    public function checkStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'search' => 'required|string'
            ]);

            $search = $request->input('search');
            
            // Search by appointment number, email, or phone
            $appointment = Appointment::with(['customer', 'location', 'inspector', 'inspection'])
                ->where(function($query) use ($search) {
                    $query->where('appointment_number', $search)
                          ->orWhereHas('customer', function($q) use ($search) {
                              $q->where('email', $search)
                                ->orWhere('phone', $search);
                          });
                })
                ->first();

            if (!$appointment) {
                return back()->withErrors(['search' => 'No appointment found with the provided information.']);
            }

            return view('appointment.status', compact('appointment'));
        }

        return view('appointment.check-status');
    }

    public function reschedule($appointmentNumber)
    {
        $appointment = Appointment::with(['customer', 'location'])
                                 ->where('appointment_number', $appointmentNumber)
                                 ->firstOrFail();

        if (!$appointment->canBeRescheduled()) {
            return redirect()->back()->withErrors(['error' => 'This appointment cannot be rescheduled.']);
        }

        $locations = Location::active()->get();
        
        return view('appointment.reschedule', compact('appointment', 'locations'));
    }

    public function updateReschedule(Request $request, $appointmentNumber)
    {
        $appointment = Appointment::where('appointment_number', $appointmentNumber)->firstOrFail();

        if (!$appointment->canBeRescheduled()) {
            return redirect()->back()->withErrors(['error' => 'This appointment cannot be rescheduled.']);
        }

        $validated = $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|string',
            'location_id' => 'required|exists:locations,id'
        ]);

        $appointmentDateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
        
        if (!$this->checkAvailability($validated['location_id'], $appointmentDateTime, $appointment->id)) {
            return back()->withErrors(['appointment_time' => 'This time slot is not available.'])->withInput();
        }

        $appointment->update([
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'location_id' => $validated['location_id'],
            'status' => 'rescheduled'
        ]);

        return redirect()->route('appointment.confirmation', $appointment->appointment_number)
                        ->with('success', 'Your appointment has been successfully rescheduled!');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id',
            'date' => 'required|date|after:today'
        ]);

        $locationId = $request->input('location_id');
        $date = $request->input('date');

        $availableSlots = $this->getAvailableSlotsForDate($locationId, $date);

        return response()->json(['slots' => $availableSlots]);
    }

    private function checkAvailability($locationId, $dateTime, $excludeAppointmentId = null)
    {
        $date = $dateTime->format('Y-m-d');
        $time = $dateTime->format('H:i:s');

        $query = Appointment::where('location_id', $locationId)
                           ->where('appointment_date', $date)
                           ->where('appointment_time', $time)
                           ->whereIn('status', ['pending', 'confirmed', 'in_progress']);

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return $query->count() === 0;
    }

    private function getAvailableSlotsForDate($locationId, $date)
    {
        $location = Location::find($locationId);
        $dayOfWeek = Carbon::parse($date)->format('l'); // Monday, Tuesday, etc.
        
        // Default operating hours (you can customize this based on location)
        $operatingHours = $location->operating_hours ?? [
            'Monday' => ['09:00', '17:00'],
            'Tuesday' => ['09:00', '17:00'],
            'Wednesday' => ['09:00', '17:00'],
            'Thursday' => ['09:00', '17:00'],
            'Friday' => ['09:00', '17:00'],
            'Saturday' => ['09:00', '15:00'],
            'Sunday' => null // Closed
        ];

        if (!isset($operatingHours[$dayOfWeek]) || $operatingHours[$dayOfWeek] === null) {
            return []; // Closed on this day
        }

        [$startTime, $endTime] = $operatingHours[$dayOfWeek];
        $slots = [];
        
        // Generate 30-minute slots
        $current = Carbon::parse($date . ' ' . $startTime);
        $end = Carbon::parse($date . ' ' . $endTime);
        
        while ($current->lt($end)) {
            $timeSlot = $current->format('H:i');
            
            // Check if this slot is available
            if ($this->checkAvailability($locationId, $current)) {
                $slots[] = [
                    'time' => $timeSlot,
                    'display' => $current->format('g:i A')
                ];
            }
            
            $current->addMinutes(30);
        }

        return $slots;
    }
}
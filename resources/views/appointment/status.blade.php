@extends('layouts.app')

@section('title', 'Appointment Status - ' . $appointment->appointment_number)

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto">
        <!-- Status Header -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Appointment Status</h1>
                <p class="text-gray-600">Appointment #{{ $appointment->appointment_number }}</p>
            </div>

            <!-- Status Badge -->
            <div class="flex justify-center mb-6">
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'confirmed' => 'bg-blue-100 text-blue-800',
                        'rescheduled' => 'bg-purple-100 text-purple-800',
                        'in_progress' => 'bg-indigo-100 text-indigo-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusColor = $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="px-6 py-2 rounded-full text-lg font-semibold {{ $statusColor }}">
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                </span>
            </div>

            <!-- Appointment Details -->
            <div class="grid md:grid-cols-2 gap-6 border-t pt-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">CUSTOMER INFORMATION</h3>
                    <p class="text-gray-900 mb-1">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</p>
                    <p class="text-gray-600 text-sm">{{ $appointment->customer->phone }}</p>
                    <p class="text-gray-600 text-sm">{{ $appointment->customer->email }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">VEHICLE INFORMATION</h3>
                    <p class="text-gray-900 mb-1">{{ $appointment->vehicle_year }} {{ $appointment->vehicle_make }} {{ $appointment->vehicle_model }}</p>
                    <p class="text-gray-600 text-sm">Type: {{ ucfirst($appointment->vehicle_type) }}</p>
                    @if($appointment->vin)
                        <p class="text-gray-600 text-sm">VIN: {{ $appointment->vin }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">APPOINTMENT DETAILS</h3>
                    <p class="text-gray-900 mb-1">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</p>
                    <p class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                    <p class="text-gray-600 text-sm">Duration: ~{{ $appointment->estimated_duration }} minutes</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">LOCATION</h3>
                    <p class="text-gray-900 mb-1">{{ $appointment->location->name }}</p>
                    <p class="text-gray-600 text-sm">{{ $appointment->location->address }}</p>
                    <p class="text-gray-600 text-sm">{{ $appointment->location->city }}, {{ $appointment->location->state }} {{ $appointment->location->zip_code }}</p>
                </div>

                @if($appointment->inspector)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">ASSIGNED INSPECTOR</h3>
                    <p class="text-gray-900 mb-1">{{ $appointment->inspector->first_name }} {{ $appointment->inspector->last_name }}</p>
                    <p class="text-gray-600 text-sm">{{ $appointment->inspector->phone }}</p>
                </div>
                @endif

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 mb-3">PACKAGE</h3>
                    <p class="text-gray-900 mb-1">{{ ucfirst($appointment->package_type) }} Inspection</p>
                    <p class="text-gray-600 text-sm">Price: ${{ number_format($appointment->price, 2) }}</p>
                </div>
            </div>

            @if($appointment->customer_notes)
            <div class="border-t pt-6 mt-6">
                <h3 class="text-sm font-semibold text-gray-500 mb-2">CUSTOMER NOTES</h3>
                <p class="text-gray-700">{{ $appointment->customer_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(in_array($appointment->status, ['pending', 'confirmed']))
                <a href="{{ route('appointment.reschedule', $appointment->appointment_number) }}" 
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition text-center">
                    Reschedule Appointment
                </a>
            @endif
            
            <a href="{{ route('home') }}" 
               class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
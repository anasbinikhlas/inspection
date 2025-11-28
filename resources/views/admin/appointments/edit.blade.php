@extends('layouts.admin')

@section('header', 'Edit Appointment')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Customer Selection -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer *</label>
                    <select name="customer_id" id="customer_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $appointment->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->full_name }} - {{ $customer->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vehicle Information -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="vehicle_make" class="block text-sm font-medium text-gray-700">Make *</label>
                            <input type="text" name="vehicle_make" id="vehicle_make" value="{{ old('vehicle_make', $appointment->vehicle_make) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('vehicle_make')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_model" class="block text-sm font-medium text-gray-700">Model *</label>
                            <input type="text" name="vehicle_model" id="vehicle_model" value="{{ old('vehicle_model', $appointment->vehicle_model) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('vehicle_model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_year" class="block text-sm font-medium text-gray-700">Year *</label>
                            <input type="number" name="vehicle_year" id="vehicle_year" value="{{ old('vehicle_year', $appointment->vehicle_year) }}" required
                                   min="1990" max="{{ date('Y') + 1 }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('vehicle_year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Type *</label>
                            <select name="vehicle_type" id="vehicle_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Type...</option>
                                <option value="sedan" {{ old('vehicle_type', $appointment->vehicle_type) == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ old('vehicle_type', $appointment->vehicle_type) == 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="truck" {{ old('vehicle_type', $appointment->vehicle_type) == 'truck' ? 'selected' : '' }}>Truck</option>
                                <option value="van" {{ old('vehicle_type', $appointment->vehicle_type) == 'van' ? 'selected' : '' }}>Van</option>
                                <option value="coupe" {{ old('vehicle_type', $appointment->vehicle_type) == 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="hatchback" {{ old('vehicle_type', $appointment->vehicle_type) == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                            </select>
                            @error('vehicle_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="text" name="color" id="color" value="{{ old('color', $appointment->color) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage</label>
                            <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $appointment->mileage) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="vin" class="block text-sm font-medium text-gray-700">VIN</label>
                            <input type="text" name="vin" id="vin" value="{{ old('vin', $appointment->vin) }}" maxlength="17"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="license_plate" class="block text-sm font-medium text-gray-700">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate', $appointment->license_plate) }}"
class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
</div>
</div>
</div>

<!-- Appointment Details -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="package_type" class="block text-sm font-medium text-gray-700">Package *</label>
                        <select name="package_type" id="package_type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="basic" {{ old('package_type', $appointment->package_type) == 'basic' ? 'selected' : '' }}>Basic - $99</option>
                            <option value="complete" {{ old('package_type', $appointment->package_type) == 'complete' ? 'selected' : '' }}>Complete - $199</option>
                            <option value="premium" {{ old('package_type', $appointment->package_type) == 'premium' ? 'selected' : '' }}>Premium - $299</option>
                        </select>
                        @error('package_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location_id" class="block text-sm font-medium text-gray-700">Location *</label>
                        <select name="location_id" id="location_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id', $appointment->location_id) == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date *</label>
                        <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('appointment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="appointment_time" class="block text-sm font-medium text-gray-700">Time *</label>
                        <select name="appointment_time" id="appointment_time" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Time...</option>
                            @foreach(['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                <option value="{{ $time }}" {{ old('appointment_time', $appointment->appointment_time->format('H:i')) == $time ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($time)->format('g:i A') }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="inspector_id" class="block text-sm font-medium text-gray-700">Inspector</label>
                        <select name="inspector_id" id="inspector_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Not assigned</option>
                            @foreach($inspectors as $inspector)
                                <option value="{{ $inspector->id }}" {{ old('inspector_id', $appointment->inspector_id) == $inspector->id ? 'selected' : '' }}>
                                    {{ $inspector->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="in_progress" {{ old('status', $appointment->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="no_show" {{ old('status', $appointment->status) == 'no_show' ? 'selected' : '' }}>No Show</option>
                            <option value="rescheduled" {{ old('status', $appointment->status) == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="customer_notes" class="block text-sm font-medium text-gray-700">Customer Notes</label>
                        <textarea name="customer_notes" id="customer_notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('customer_notes', $appointment->customer_notes) }}</textarea>
                    </div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes (Internal)</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('admin_notes', $appointment->admin_notes) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.appointments.show', $appointment) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
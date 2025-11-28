@extends('layouts.admin')

@section('header', 'Create Appointment')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Customer Selection -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer *</label>
                    <select name="customer_id" id="customer_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Customer...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
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
                            <input type="text" name="vehicle_make" id="vehicle_make" value="{{ old('vehicle_make') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('vehicle_make')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_model" class="block text-sm font-medium text-gray-700">Model *</label>
                            <input type="text" name="vehicle_model" id="vehicle_model" value="{{ old('vehicle_model') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('vehicle_model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_year" class="block text-sm font-medium text-gray-700">Year *</label>
                            <input type="number" name="vehicle_year" id="vehicle_year" value="{{ old('vehicle_year') }}" required
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
                                <option value="sedan" {{ old('vehicle_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="suv" {{ old('vehicle_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="truck" {{ old('vehicle_type') == 'truck' ? 'selected' : '' }}>Truck</option>
                                <option value="van" {{ old('vehicle_type') == 'van' ? 'selected' : '' }}>Van</option>
                                <option value="coupe" {{ old('vehicle_type') == 'coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="hatchback" {{ old('vehicle_type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                            </select>
                            @error('vehicle_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="text" name="color" id="color" value="{{ old('color') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage</label>
                            <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="vin" class="block text-sm font-medium text-gray-700">VIN</label>
                            <input type="text" name="vin" id="vin" value="{{ old('vin') }}" maxlength="17"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="license_plate" class="block text-sm font-medium text-gray-700">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate" value="{{ old('license_plate') }}"
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
                                <option value="basic" {{ old('package_type') == 'basic' ? 'selected' : '' }}>Basic - $99</option>
                                <option value="complete" {{ old('package_type', 'complete') == 'complete' ? 'selected' : '' }}>Complete - $199</option>
                                <option value="premium" {{ old('package_type') == 'premium' ? 'selected' : '' }}>Premium - $299</option>
                            </select>
                            @error('package_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700">Location *</label>
                            <select name="location_id" id="location_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Location...</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date *</label>
                            <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" required
                                   min="{{ date('Y-m-d') }}"
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
                                <option value="09:00">9:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="17:00">5:00 PM</option>
                            </select>
                            @error('appointment_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="inspector_id" class="block text-sm font-medium text-gray-700">Inspector</label>
                            <select name="inspector_id" id="inspector_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Auto-assign</option>
                                @foreach($inspectors as $inspector)
                                    <option value="{{ $inspector->id }}" {{ old('inspector_id') == $inspector->id ? 'selected' : '' }}>
                                        {{ $inspector->full_name }}
                                    </option>
                                @endforeach
                            </select>
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
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('customer_notes') }}</textarea>
                        </div>

                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes (Internal)</label>
                            <textarea name="admin_notes" id="admin_notes" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('admin_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.appointments.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Create Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
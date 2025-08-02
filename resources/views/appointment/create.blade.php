@extends('layouts.public')

@section('title', 'Book Your Inspection')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Book Your Vehicle Inspection</h1>
            <p class="text-lg text-gray-600">Fill in the details below to schedule your professional vehicle inspection</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Your Details</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-car text-gray-500 text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm text-gray-500">Vehicle Info</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar text-gray-500 text-sm"></i>
                        </div>
                        <span class="ml-2 text-sm text-gray-500">Schedule</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('appointment.store') }}" method="POST" class="space-y-8" x-data="appointmentForm()">
            @csrf
            
            <!-- Customer Information -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Customer Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('first_name') border-red-500 @enderror" required>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('last_name') border-red-500 @enderror" required>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror" required>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="Street address">
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
                        <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    <i class="fas fa-car mr-2 text-blue-600"></i>
                    Vehicle Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label for="vehicle_make" class="block text-sm font-medium text-gray-700 mb-2">Make *</label>
                        <input type="text" id="vehicle_make" name="vehicle_make" value="{{ old('vehicle_make') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vehicle_make') border-red-500 @enderror" 
                               placeholder="e.g., Honda, Toyota" required>
                        @error('vehicle_make')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="vehicle_model" class="block text-sm font-medium text-gray-700 mb-2">Model *</label>
                        <input type="text" id="vehicle_model" name="vehicle_model" value="{{ old('vehicle_model') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vehicle_model') border-red-500 @enderror" 
                               placeholder="e.g., Civic, Camry" required>
                        @error('vehicle_model')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="vehicle_year" class="block text-sm font-medium text-gray-700 mb-2">Year *</label>
                        <select id="vehicle_year" name="vehicle_year" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vehicle_year') border-red-500 @enderror" required>
                            <option value="">Select Year</option>
                            @for($year = date('Y') + 1; $year >= 1990; $year--)
                                <option value="{{ $year }}" {{ old('vehicle_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('vehicle_year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-2">Vehicle Type *</label>
                        <select id="vehicle_type" name="vehicle_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vehicle_type') border-red-500 @enderror" required>
                            <option value="">Select Type</option>
                            <option value="sedan" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="suv" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'suv' ? 'selected' : '' }}>SUV</option>
                            <option value="hatchback" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                            <option value="truck" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'truck' ? 'selected' : '' }}>Truck</option>
                            <option value="motorcycle" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                            <option value="van" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'van' ? 'selected' : '' }}>Van</option>
                            <option value="coupe" {{ old('vehicle_type', $prefilledData['vehicle_type']) == 'coupe' ? 'selected' : '' }}>Coupe</option>
                        </select>
                        @error('vehicle_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="mileage" class="block text-sm font-medium text-gray-700 mb-2">Mileage</label>
                        <input type="number" id="mileage" name="mileage" value="{{ old('mileage') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="e.g., 50000">
                    </div>
                    
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                        <input type="text" id="color" name="color" value="{{ old('color') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               placeholder="e.g., Blue, Red">
                    </div>
                    
                    <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="vin" class="block text-sm font-medium text-gray-700 mb-2">VIN (Vehicle Identification Number)</label>
                            <input type="text" id="vin" name="vin" value="{{ old('vin') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="17-character VIN" maxlength="17">
                        </div>
                        
                        <div>
                            <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-2">License Plate</label>
                            <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="e.g., ABC-123">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Package Selection -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    <i class="fas fa-package mr-2 text-blue-600"></i>
                    Select Package
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($packages as $key => $package)
                        <div class="relative">
                            <input type="radio" id="package_{{ $key }}" name="package_type" value="{{ $key }}" 
                                   class="sr-only" {{ old('package_type', $selectedPackage) == $key ? 'checked' : '' }}>
                            <label for="package_{{ $key }}" class="block cursor-pointer">
                                <div class="border-2 rounded-lg p-6 hover:border-blue-500 transition-colors {{ old('package_type', $selectedPackage) == $key ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                    <div class="text-center">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $package['name'] }}</h3>
                                        <div class="text-3xl font-bold text-blue-600 mb-4">${{ $package['price'] }}</div>
                                        
                                        @if($key == 'basic')
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>✓ Engine basics</li>
                                                <li>✓ Brake inspection</li>
                                                <li>✓ Tire condition</li>
                                                <li>✓ Basic report</li>
                                            </ul>
                                        @elseif($key == 'complete')
                                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Most Popular</span>
                                            </div>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>✓ All 13 inspection points</li>
                                                <li>✓ Detailed PDF report</li>
                                                <li>✓ Photo documentation</li>
                                                <li>✓ Damage mapping</li>
                                                <li>✓ Test drive included</li>
                                            </ul>
                                        @else
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                <li>✓ Everything in Complete</li>
                                                <li>✓ Mobile service</li>
                                                <li>✓ Same-day report</li>
                                                <li>✓ Priority scheduling</li>
                                                <li>✓ Follow-up consultation</li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('package_type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Appointment Scheduling -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    <i class="fas fa-calendar mr-2 text-blue-600"></i>
                    Schedule Appointment
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="location_id" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                        <select id="location_id" name="location_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location_id') border-red-500 @enderror" 
                                x-model="selectedLocation" @change="loadAvailableSlots()" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id', $prefilledData['location']) == $location->code ? 'selected' : '' }}>
                                    {{ $location->name }} - {{ $location->city }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Preferred Date *</label>
                        <input type="date" id="appointment_date" name="appointment_date" 
                               value="{{ old('appointment_date', $prefilledData['preferred_date']) }}" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('appointment_date') border-red-500 @enderror" 
                               x-model="selectedDate" @change="loadAvailableSlots()" required>
                        @error('appointment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Available Times *</label>
                        <div x-show="loadingSlots" class="text-center py-4">
                            <i class="fas fa-spinner fa-spin text-blue-500"></i>
                            <span class="ml-2 text-gray-600">Loading available times...</span>
                        </div>
                        
                        <div x-show="!loadingSlots && availableSlots.length === 0 && selectedLocation && selectedDate" class="text-center py-4 text-gray-500">
                            No available time slots for the selected date and location.
                        </div>
                        
                        <div x-show="!loadingSlots && availableSlots.length > 0" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                            <template x-for="slot in availableSlots" :key="slot.time">
                                <label class="cursor-pointer">
                                    <input type="radio" name="appointment_time" :value="slot.time" class="sr-only" 
                                           x-model="selectedTime">
                                    <div class="border-2 rounded-lg px-4 py-2 text-center hover:border-blue-500 transition-colors"
                                         :class="selectedTime === slot.time ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200'">
                                        <span class="text-sm font-medium" x-text="slot.display"></span>
                                    </div>
                                </label>
                            </template>
                        </div>
                        @error('appointment_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="customer_notes" class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                        <textarea id="customer_notes" name="customer_notes" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                  placeholder="Any specific concerns or requests about your vehicle...">{{ old('customer_notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Summary & Submit -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                    Booking Summary
                </h2>
                
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">Package:</span>
                            <span x-text="getSelectedPackageName()"></span>
                        </div>
                        <div>
                            <span class="font-medium">Price:</span>
                            <span class="text-green-600 font-bold" x-text="'$' + getSelectedPackagePrice()"></span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center mb-6">
                    <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms of Service</a> and 
                        <a href="#" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 px-6 rounded-lg text-lg font-semibold transition duration-300 flex items-center justify-center">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Book Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function appointmentForm() {
    return {
        selectedLocation: '{{ old('location_id') }}',
        selectedDate: '{{ old('appointment_date', $prefilledData['preferred_date']) }}',
        selectedTime: '{{ old('appointment_time') }}',
        availableSlots: [],
        loadingSlots: false,
        
        async loadAvailableSlots() {
            if (!this.selectedLocation || !this.selectedDate) {
                this.availableSlots = [];
                return;
            }
            
            this.loadingSlots = true;
            this.selectedTime = '';
            
            try {
                const response = await fetch('/api/available-slots?' + new URLSearchParams({
                    location_id: this.selectedLocation,
                    date: this.selectedDate
                }));
                
                const data = await response.json();
                this.availableSlots = data.slots || [];
            } catch (error) {
                console.error('Error loading available slots:', error);
                this.availableSlots = [];
            } finally {
                this.loadingSlots = false;
            }
        },
        
        getSelectedPackageName() {
            const packages = {!! json_encode($packages) !!};
            const selected = document.querySelector('input[name="package_type"]:checked');
            return selected ? packages[selected.value].name : 'Not selected';
        },
        
        getSelectedPackagePrice() {
            const packages = {!! json_encode($packages) !!};
            const selected = document.querySelector('input[name="package_type"]:checked');
            return selected ? packages[selected.value].price : 0;
        }
    }
}
</script>
@endsection
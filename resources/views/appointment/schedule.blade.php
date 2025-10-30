@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">
                <i class="fas fa-calendar-alt text-blue-600"></i>
                Schedule Your Inspection
            </h1>
            <p class="text-lg text-gray-600">
                Book a professional vehicle inspection at your convenience
            </p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <form action="{{ route('appointment.store') }}" method="POST" class="space-y-4" 
                  x-data="{
                      selectedLocation: '',
                      selectedDate: '',
                      availableSlots: [],
                      checkingAvailability: false,
                      vehicleMakes: ['Toyota', 'Honda', 'Nissan', 'Suzuki', 'Mercedes', 'BMW', 'Audi', 'Hyundai', 'KIA', 'Mazda', 'Ford', 'Chevrolet'],
                      selectedMake: '',
                      vehicleModels: [],
                      
                      init() {
                          // Auto-populate time slots on load for testing
                          this.availableSlots = [
                              {value: '09:00', display: '9:00 AM'},
                              {value: '10:00', display: '10:00 AM'},
                              {value: '11:00', display: '11:00 AM'},
                              {value: '14:00', display: '2:00 PM'},
                              {value: '15:00', display: '3:00 PM'},
                              {value: '16:00', display: '4:00 PM'}
                          ];
                      },
                      
                      checkAvailability() {
                          if (!this.selectedLocation || !this.selectedDate) return;
                          
                          this.checkingAvailability = true;
                          this.availableSlots = [];
                          
                          // Call actual API endpoint
                          fetch(`/api/check-availability?date=${this.selectedDate}&location_id=${this.selectedLocation}`)
                              .then(response => response.json())
                              .then(data => {
                                  this.availableSlots = data.time_slots || [];
                                  this.checkingAvailability = false;
                              })
                              .catch(error => {
                                  console.error('Error:', error);
                                  // Fallback time slots
                                  this.availableSlots = [
                                      {value: '09:00', display: '9:00 AM'},
                                      {value: '10:00', display: '10:00 AM'},
                                      {value: '11:00', display: '11:00 AM'},
                                      {value: '14:00', display: '2:00 PM'},
                                      {value: '15:00', display: '3:00 PM'},
                                      {value: '16:00', display: '4:00 PM'}
                                  ];
                                  this.checkingAvailability = false;
                              });
                      },
                      
                      getModelsForMake(make) {
                          const models = {
                              'Toyota': ['Corolla', 'Camry', 'Prado', 'Hilux', 'Vitz', 'Passo'],
                              'Honda': ['Civic', 'City', 'Accord', 'CR-V', 'BR-V', 'Vezel'],
                              'Suzuki': ['Cultus', 'Swift', 'Wagon R', 'Alto', 'Mehran', 'Jimny'],
                              'Nissan': ['Sunny', 'Altima', 'X-Trail', 'Patrol', 'Micra'],
                              'Mercedes': ['C-Class', 'E-Class', 'S-Class', 'GLA', 'GLC'],
                              'BMW': ['3 Series', '5 Series', '7 Series', 'X1', 'X3', 'X5'],
                              'Audi': ['A3', 'A4', 'A6', 'Q3', 'Q5', 'Q7'],
                              'Hyundai': ['Elantra', 'Sonata', 'Tucson', 'Santa Fe'],
                              'KIA': ['Sportage', 'Picanto', 'Rio', 'Sorento'],
                              'Mazda': ['3', '6', 'CX-5', 'CX-9'],
                              'Ford': ['Focus', 'Fusion', 'Explorer', 'F-150'],
                              'Chevrolet': ['Cruze', 'Malibu', 'Equinox', 'Silverado']
                          };
                          return models[make] || [];
                      }
                  }">
                @csrf
                
                <!-- Customer Information Section -->
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                        Customer Information
                    </h2>
                </div>

                <!-- Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="customer_name" required 
                           value="{{ old('customer_name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your full name">
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                    <input type="tel" name="customer_phone" required 
                           value="{{ old('customer_phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="+92 300 1234567">
                </div>

                <!-- Email (hidden field - auto-generated in backend) -->
                <input type="hidden" name="customer_email" value="">

                <!-- Vehicle Information Section -->
                <div class="border-b border-gray-200 pb-4 mb-4 mt-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-car text-blue-600 mr-2"></i>
                        Vehicle Information
                    </h2>
                </div>

                <!-- Vehicle Make -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Make *</label>
                    <select name="vehicle_make" required x-model="selectedMake"
                            @change="vehicleModels = getModelsForMake(selectedMake)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Make</option>
                        <template x-for="make in vehicleMakes" :key="make">
                            <option :value="make" x-text="make"></option>
                        </template>
                    </select>
                </div>

                <!-- Vehicle Model -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Model *</label>
                    <input type="text" name="vehicle_model" required 
                           value="{{ old('vehicle_model') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., Corolla, Civic, City">
                </div>

                <!-- Vehicle Year -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Year *</label>
                    <select name="vehicle_year" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Year</option>
                        @php
                            $currentYear = date('Y');
                            for($year = $currentYear; $year >= 2000; $year--) {
                                $selected = old('vehicle_year') == $year ? 'selected' : '';
                                echo "<option value='{$year}' {$selected}>{$year}</option>";
                            }
                        @endphp
                    </select>
                </div>

                <!-- Appointment Details Section -->
                <div class="border-b border-gray-200 pb-4 mb-4 mt-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-calendar-check text-blue-600 mr-2"></i>
                        Appointment Details
                    </h2>
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Inspection Location *</label>
                    <select name="location_id" required x-model="selectedLocation"
                            @change="checkAvailability()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Location</option>
                        <option value="1">Downtown Center - Main Office</option>
                        <option value="2">North Branch - Industrial Area</option>
                        <option value="3">South Branch - Commercial District</option>
                        <option value="4">Mobile Service - We Come to You</option>
                    </select>
                </div>

                <!-- Inspection Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date *</label>
                    <input type="date" name="appointment_date" required x-model="selectedDate"
                           @change="checkAvailability()" 
                           :min="new Date().toISOString().split('T')[0]"
                           value="{{ old('appointment_date') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Loading indicator -->
                <div x-show="checkingAvailability" class="text-center py-2">
                    <i class="fas fa-spinner fa-spin text-blue-600"></i>
                    <span class="ml-2 text-sm text-gray-600">Checking availability...</span>
                </div>

                <!-- Time Slots -->
                <div x-show="availableSlots.length > 0">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Available Time Slots *</label>
                    <select name="appointment_time" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Time</option>
                        <template x-for="slot in availableSlots" :key="slot.value">
                            <option :value="slot.value" x-text="slot.display"></option>
                        </template>
                    </select>
                </div>

                <!-- Service Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Inspection Package *</label>
                    <select name="service_type" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="basic">Basic Inspection - $99</option>
                        <option value="comprehensive" selected>Complete Inspection - $199</option>
                        <option value="premium">Premium Plus - $299</option>
                    </select>
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i>
                        All packages include detailed report and expert recommendations
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Book Appointment
                    </button>
                </div>

                <p class="text-center text-sm text-gray-500 mt-4">
                    Need help? Contact us at <a href="tel:+923001234567" class="text-blue-600 hover:underline">+92 300 1234567</a>
                </p>
            </form>
        </div>

        <!-- Info Cards Below Form -->
        <div class="grid md:grid-cols-3 gap-4 mt-8">
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <i class="fas fa-clock text-3xl text-blue-600 mb-2"></i>
                <h3 class="font-semibold text-gray-800">Quick Service</h3>
                <p class="text-sm text-gray-600">Most inspections completed in 1-2 hours</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <i class="fas fa-certificate text-3xl text-blue-600 mb-2"></i>
                <h3 class="font-semibold text-gray-800">Certified Experts</h3>
                <p class="text-sm text-gray-600">ASE certified technicians</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 text-center">
                <i class="fas fa-file-alt text-3xl text-blue-600 mb-2"></i>
                <h3 class="font-semibold text-gray-800">Detailed Report</h3>
                <p class="text-sm text-gray-600">Comprehensive inspection documentation</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection
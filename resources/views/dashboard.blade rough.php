@extends('layouts.app')

@section('title', 'ProInspect - Professional Vehicle Inspection Service')

@section('content')
<!-- Hero Section -->
<section id="home" class="gradient-bg min-h-screen flex items-center pt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Professional Vehicle 
                    <span class="text-yellow-300">Inspection</span> Service
                </h1>
                <p class="text-xl mb-8 text-gray-100">
                    Get comprehensive 13-point vehicle inspections from certified professionals. 
                    Know your car's true condition before you buy, sell, or maintain.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('appointment.schedule') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 text-center shadow-lg">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Book Inspection
                    </a>
                    <a href="#services" class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 text-center">
                        Learn More
                    </a>
                </div>
            </div>
            
            <!-- Hero Image/Illustration -->
            <div class="hidden lg:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-400 rounded-full blur-3xl opacity-20"></div>
                    <img src="/api/placeholder/600/400" alt="Vehicle Inspection" class="relative rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl font-bold text-blue-600 mb-2">10,000+</div>
                <div class="text-gray-600">Inspections Completed</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-blue-600 mb-2">98%</div>
                <div class="text-gray-600">Customer Satisfaction</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-blue-600 mb-2">24/7</div>
                <div class="text-gray-600">Support Available</div>
            </div>
            <div class="p-6">
                <div class="text-4xl font-bold text-blue-600 mb-2">50+</div>
                <div class="text-gray-600">Certified Inspectors</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Inspection Services</h2>
            <p class="text-xl text-gray-600">Comprehensive vehicle inspection packages tailored to your needs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Basic Inspection -->
            <div class="bg-white rounded-lg shadow-lg p-8 card-hover border-t-4 border-blue-500">
                <div class="text-blue-600 text-4xl mb-4">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Basic Inspection</h3>
                <p class="text-gray-600 mb-6">Essential checks for regular maintenance and basic vehicle assessment.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Engine & Transmission
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Brake System
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Tire Condition
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Basic Fluids Check
                    </li>
                </ul>
                <div class="text-3xl font-bold text-gray-900 mb-4">$99</div>
                <a href="{{ route('appointment.schedule') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold transition duration-300">
                    Book Now
                </a>
            </div>

            <!-- Complete Inspection -->
            <div class="bg-white rounded-lg shadow-lg p-8 card-hover border-t-4 border-purple-500 transform scale-105">
                <div class="absolute top-0 right-0 bg-purple-500 text-white px-4 py-1 rounded-bl-lg text-sm font-semibold">
                    POPULAR
                </div>
                <div class="text-purple-600 text-4xl mb-4">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Complete Inspection</h3>
                <p class="text-gray-600 mb-6">Thorough 13-point inspection for comprehensive vehicle assessment.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        All Basic Checks
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Suspension System
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Electrical System
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Body & Paint Check
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Detailed Report
                    </li>
                </ul>
                <div class="text-3xl font-bold text-gray-900 mb-4">$199</div>
                <a href="{{ route('appointment.schedule') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-3 rounded-lg font-semibold transition duration-300">
                    Book Now
                </a>
            </div>

            <!-- Premium Inspection -->
            <div class="bg-white rounded-lg shadow-lg p-8 card-hover border-t-4 border-yellow-500">
                <div class="text-yellow-600 text-4xl mb-4">
                    <i class="fas fa-crown"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Premium Plus</h3>
                <p class="text-gray-600 mb-6">Most comprehensive inspection with diagnostic testing and warranty.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        All Complete Checks
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Computer Diagnostics
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Road Test
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Video Documentation
                    </li>
                    <li class="flex items-center text-gray-700">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        30-Day Warranty
                    </li>
                </ul>
                <div class="text-3xl font-bold text-gray-900 mb-4">$299</div>
                <a href="{{ route('appointment.schedule') }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white text-center py-3 rounded-lg font-semibold transition duration-300">
                    Book Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose ProInspect?</h2>
            <p class="text-xl text-gray-600">Industry-leading inspection services with unmatched expertise</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-certificate text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Certified Experts</h3>
                <p class="text-gray-600">ASE-certified technicians with years of experience in vehicle inspection</p>
            </div>
            
            <div class="text-center p-6">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clipboard-list text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Detailed Reports</h3>
                <p class="text-gray-600">Comprehensive digital reports with photos and recommendations</p>
            </div>
            
            <div class="text-center p-6">
                <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Quick Turnaround</h3>
                <p class="text-gray-600">Most inspections completed within 1-2 hours with instant digital delivery</p>
            </div>
        </div>
    </div>
</section>

<!-- Booking Form Section -->
<section id="booking" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Book Your Inspection</h2>
            <p class="text-xl text-gray-600">Fill out the form below to schedule your appointment</p>
        </div>
        
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
                          
                          fetch(`/api/check-availability?date=${this.selectedDate}&location_id=${this.selectedLocation}`)
                              .then(response => response.json())
                              .then(data => {
                                  this.availableSlots = data.time_slots || [];
                                  this.checkingAvailability = false;
                              })
                              .catch(error => {
                                  console.error('Error:', error);
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
                
                <!-- Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="customer_name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your full name">
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                    <input type="tel" name="customer_phone" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="+92 300 1234567">
                </div>

                <!-- Email (hidden field - auto-generated in backend) -->
                <input type="hidden" name="customer_email" value="">

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Inspection Location *</label>
                    <select name="location_id" required x-model="selectedLocation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Location</option>
                        <option value="1">Downtown Center - Main Office</option>
                        <option value="2">North Branch - Industrial Area</option>
                        <option value="3">South Branch - Commercial District</option>
                        <option value="4">Mobile Service - We Come to You</option>
                    </select>
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
                                echo "<option value='{$year}'>{$year}</option>";
                            }
                        @endphp
                    </select>
                </div>

                <!-- Inspection Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date *</label>
                    <input type="date" name="appointment_date" required x-model="selectedDate"
                           @change="checkAvailability()" 
                           :min="new Date().toISOString().split('T')[0]"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                </div>

                <!-- Loading indicator -->
                <div x-show="checkingAvailability" class="text-center py-2">
                    <i class="fas fa-spinner fa-spin text-blue-600"></i>
                    <span class="ml-2 text-sm text-gray-600">Checking availability...</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Book Appointment
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-4xl font-bold mb-6">Get In Touch</h2>
                <p class="text-gray-300 mb-8">
                    Have questions? We're here to help. Contact us for any inquiries about our services.
                </p>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div class="font-semibold">Phone</div>
                            <div class="text-gray-300">+92 300 1234567</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="font-semibold">Email</div>
                            <div class="text-gray-300">info@proinspect.com</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-blue-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div class="font-semibold">Location</div>
                            <div class="text-gray-300">Main Office, Downtown Center, Karachi</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 p-8 rounded-lg">
                <h3 class="text-2xl font-bold mb-6">Send Us a Message</h3>
                <form class="space-y-4">
                    <input type="text" placeholder="Your Name" 
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white">
                    <input type="email" placeholder="Your Email" 
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white">
                    <textarea rows="4" placeholder="Your Message" 
                              class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white"></textarea>
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
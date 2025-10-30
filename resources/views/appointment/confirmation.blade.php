@extends('layouts.app')

@section('title', 'Appointment Confirmed')

@section('content')
<!-- Header Section -->
<header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <i class="fas fa-car-side text-3xl text-blue-600 mr-2"></i>
                    <span class="text-2xl font-bold text-gray-900">Vehicle Inspection</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="{{ route('appointment.schedule') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-calendar-plus mr-1"></i> Book Appointment
                </a>
                <a href="{{ route('appointment.check-status') }}" class="text-blue-600 font-semibold">
                    <i class="fas fa-search mr-1"></i> Check Status
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button type="button" class="text-gray-600 hover:text-blue-600" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition py-2">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="{{ route('appointment.schedule') }}" class="text-gray-600 hover:text-blue-600 transition py-2">
                    <i class="fas fa-calendar-plus mr-1"></i> Book Appointment
                </a>
                <a href="{{ route('appointment.check-status') }}" class="text-blue-600 font-semibold py-2">
                    <i class="fas fa-search mr-1"></i> Check Status
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="fas fa-check-circle text-4xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Appointment Confirmed!
            </h1>
            <p class="text-lg text-gray-600">
                Thank you for booking with us. Your appointment has been scheduled.
            </p>
        </div>

        <!-- Appointment Details Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            
            <!-- Appointment Number Banner -->
            <div class="bg-blue-600 text-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Appointment Number</p>
                        <p class="text-2xl font-bold">{{ $appointment->appointment_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-400 text-gray-900">
                            <i class="fas fa-clock mr-2"></i>
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                
                <!-- Customer Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i>
                        Customer Information
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->customer->full_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phone:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->customer->phone }}</span>
                        </div>
                        @if($appointment->customer->email && !str_contains($appointment->customer->email, 'noemail'))
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->customer->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Appointment Schedule -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        Appointment Schedule
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Time:</span>
                            <span class="font-semibold text-gray-900">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Duration:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->estimated_duration }} minutes</span>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-car text-blue-600 mr-2"></i>
                        Vehicle Information
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Vehicle:</span>
                            <span class="font-semibold text-gray-900">{{ $appointment->vehicle_full_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst($appointment->vehicle_type) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Inspection Package -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>
                        Inspection Package
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Package:</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst($appointment->package_type) }} Inspection</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Price:</span>
                            <span class="font-semibold text-green-600 text-lg">{{ $appointment->formatted_price }}</span>
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                        Inspection Location
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">{{ $appointment->location->name }}</p>
                        @if($appointment->location->address)
                        <p class="text-gray-600 text-sm mt-1">{{ $appointment->location->address }}</p>
                        @endif
                    </div>
                </div>

                @if($appointment->inspector)
                <!-- Inspector Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-user-tie text-blue-600 mr-2"></i>
                        Your Inspector
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="font-semibold text-gray-900">{{ $appointment->inspector->name }}</p>
                        @if($appointment->inspector->phone)
                        <p class="text-gray-600 text-sm mt-1">
                            <i class="fas fa-phone mr-1"></i>{{ $appointment->inspector->phone }}
                        </p>
                        @endif
                    </div>
                </div>
                @endif

                @if($appointment->customer_notes)
                <!-- Customer Notes -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-sticky-note text-blue-600 mr-2"></i>
                        Your Notes
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $appointment->customer_notes }}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>

        <!-- Important Information -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                Important Information
            </h3>
            <ul class="space-y-2 text-blue-800">
                <li class="flex items-start">
                    <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                    <span>Please arrive 10 minutes before your scheduled time</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                    <span>Bring your vehicle registration and any relevant documents</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                    <span>A confirmation SMS/Email will be sent 24 hours before your appointment</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                    <span>Save your appointment number for future reference</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('home') }}" 
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-6 rounded-lg font-semibold transition duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-home mr-2"></i>
                Back to Home
            </a>
            
            <button onclick="window.print()" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-3 px-6 rounded-lg font-semibold transition duration-300 shadow-md hover:shadow-lg no-print">
                <i class="fas fa-print mr-2"></i>
                Print Confirmation
            </button>
            
            <a href="{{ route('appointment.check-status') }}" 
               class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-3 px-6 rounded-lg font-semibold transition duration-300 shadow-md hover:shadow-lg">
                <i class="fas fa-search mr-2"></i>
                Check Status
            </a>
        </div>

        <!-- Support Contact -->
        <div class="text-center mt-8 text-gray-600">
            <p class="mb-2">Need to reschedule or have questions?</p>
            <p class="font-semibold text-gray-900">
                <i class="fas fa-phone mr-2"></i>Call us: +92 300 1234567
            </p>
            <p class="text-sm mt-2">
                <i class="fas fa-envelope mr-2"></i>Email: support@vehicleinspection.com
            </p>
        </div>

    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Vehicle Inspection</h3>
                <p class="text-gray-400 text-sm">
                    Professional vehicle inspection services you can trust. Serving customers with quality and reliability since 2020.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('appointment.schedule') }}" class="text-gray-400 hover:text-white transition">Book Appointment</a></li>
                    <li><a href="{{ route('appointment.check-status') }}" class="text-gray-400 hover:text-white transition">Check Status</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><i class="fas fa-phone mr-2"></i>+92 300 1234567</li>
                    <li><i class="fas fa-envelope mr-2"></i>support@vehicleinspection.com</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i>Main Office, Downtown Center</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} Vehicle Inspection. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Print Styles -->
<style>
    @media print {
        body {
            background: white;
        }
        .no-print,
        header,
        footer {
            display: none !important;
        }
        .shadow-lg,
        .shadow-md {
            box-shadow: none !important;
        }
    }
</style>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>
@endsection
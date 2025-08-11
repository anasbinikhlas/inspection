<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Vehicle Inspection System</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        .service-card.selected {
            border-color: #3B82F6 !important;
            background-color: #EFF6FF !important;
        }
        
        .time-slot-button.selected {
            border-color: #3B82F6 !important;
            background-color: #DBEAFE !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-blue-600">Vehicle Inspection</h1>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Services
                    </a>
                    <a href="{{ route('pricing') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Pricing
                    </a>
                    <a href="{{ route('appointment.schedule') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Book Now
                    </a>
                    <a href="{{ route('appointment.check-status') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Check Status
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Vehicle Inspection</h3>
                    <p class="text-gray-300">Professional vehicle inspection services you can trust.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Services</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li>Basic Inspection</li>
                        <li>Comprehensive Inspection</li>
                        <li>Premium Inspection</li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ route('appointment.schedule') }}" class="hover:text-white">Book Appointment</a></li>
                        <li><a href="{{ route('appointment.check-status') }}" class="hover:text-white">Check Status</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <p class="text-gray-300">
                        Email: info@vehicleinspection.com<br>
                        Phone: +92 300 1234567
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Vehicle Inspection System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Service type selection
        function selectServiceType(type, element) {
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            element.classList.add('selected');
            document.getElementById('service_type').value = type;
            
            const pricingInfo = {
                'basic': { price: 'PKR 5,000', duration: '1-2 hours' },
                'comprehensive': { price: 'PKR 8,000', duration: '2-3 hours' },
                'premium': { price: 'PKR 12,000', duration: '3-4 hours' }
            };
            
            const selectedInfo = pricingInfo[type];
            const pricingDisplay = document.getElementById('pricing-display');
            if (pricingDisplay && selectedInfo) {
                pricingDisplay.innerHTML = `
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-green-800">Selected: ${type.charAt(0).toUpperCase() + type.slice(1)} Inspection</span>
                            <span class="text-green-600 font-bold">${selectedInfo.price}</span>
                        </div>
                        <p class="text-sm text-green-700 mt-1">Estimated Duration: ${selectedInfo.duration}</p>
                    </div>
                `;
            }
        }
    </script>
</body>
</html>
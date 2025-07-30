<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProInspect - Professional Vehicle Inspection Service</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-car text-3xl text-blue-600 mr-3"></i>
                        <span class="text-2xl font-bold text-gray-800">ProInspect</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 transition duration-300">Home</a>
                    <a href="#services" class="text-gray-700 hover:text-blue-600 transition duration-300">Services</a>
                    <a href="#pricing" class="text-gray-700 hover:text-blue-600 transition duration-300">Pricing</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 transition duration-300">Contact</a>
                    <a href="{{ route('appointment.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-300">
                        Book Now
                    </a>
                </div>
                <div class="md:hidden flex items-center">
                    <button x-data="{ open: false }" @click="open = !open" class="text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

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
                        <a href="{{ route('appointment.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 text-center">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Book Inspection
                        </a>
                        <button class="border-2 border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-lg text-lg font-semibold transition duration-300">
                            Learn More
                        </button>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="bg-white rounded-2xl p-8 shadow-2xl">
                            <div class="text-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Quick Booking</h3>
                                <p class="text-gray-600">Schedule your inspection in minutes</p>
                            </div>
                            
                            <!-- Quick Booking Form -->
                            <form action="{{ route('appointment.create') }}" method="GET" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Type</label>
                                    <select name="vehicle_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Vehicle Type</option>
                                        <option value="sedan">Sedan</option>
                                        <option value="suv">SUV</option>
                                        <option value="hatchback">Hatchback</option>
                                        <option value="truck">Truck</option>
                                        <option value="motorcycle">Motorcycle</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <select name="location" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Select Location</option>
                                        <option value="downtown">Downtown Center</option>
                                        <option value="north">North Branch</option>
                                        <option value="south">South Branch</option>
                                        <option value="mobile">Mobile Service</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                                    <input type="date" name="preferred_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300">
                                    Check Availability
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Our Inspection Services</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive 13-point inspection covering every critical component of your vehicle
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Cards -->
                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-engine text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Engine & Transmission</h3>
                        <p class="text-gray-600 mb-4">Complete engine performance analysis, fluid levels, and transmission inspection</p>
                        <ul class="text-sm text-gray-500 text-left space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Oil condition & levels</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Engine performance</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Transmission operation</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-car-crash text-2xl text-red-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Brake System</h3>
                        <p class="text-gray-600 mb-4">Safety-critical brake system inspection including pads, rotors, and fluid</p>
                        <ul class="text-sm text-gray-500 text-left space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Brake pad thickness</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Rotor condition</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Brake fluid quality</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-cog text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Suspension & Steering</h3>
                        <p class="text-gray-600 mb-4">Complete suspension system and steering component inspection</p>
                        <ul class="text-sm text-gray-500 text-left space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Shock absorbers</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Steering response</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Alignment check</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bolt text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Electrical Systems</h3>
                        <p class="text-gray-600 mb-4">Battery, alternator, lights, and electronic component testing</p>
                        <ul class="text-sm text-gray-500 text-left space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Battery health</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Charging system</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Light functionality</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-car-side text-2xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Body & Frame</h3>
                        <p class="text-gray-600 mb-4">Structural integrity, accident damage detection, and body condition</p>
                        <ul class="text-sm text-gray-500 text-left space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Frame inspection</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Paint condition</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Rust assessment</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-camera text-2xl text-yellow-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Documentation</h3>
                        <p class="text-gray-600 mb-4">Comprehensive photo documentation and detailed inspection report</p>
                        <ul class="text-sm text-gray-500 text-left space-y-1">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>HD photo documentation</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Detailed PDF report</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Damage mapping</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Transparent Pricing</h2>
                <p class="text-xl text-gray-600">Choose the inspection package that fits your needs</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Basic Package -->
                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Basic Inspection</h3>
                        <div class="text-4xl font-bold text-blue-600 mb-4">$99</div>
                        <p class="text-gray-600 mb-6">Perfect for routine check-ups</p>
                        <ul class="text-left space-y-3 mb-8">
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Engine basics</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Brake inspection</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Tire condition</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Basic report</li>
                            <li><i class="fas fa-times text-gray-400 mr-3"></i>Photo documentation</li>
                        </ul>
                        <a href="{{ route('appointment.create', ['package' => 'basic']) }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded-lg font-semibold transition duration-300 text-center">
                            Choose Basic
                        </a>
                    </div>
                </div>

                <!-- Premium Package -->
                <div class="bg-white rounded-xl shadow-lg p-8 card-hover border-4 border-blue-500 relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-blue-500 text-white px-6 py-2 rounded-full text-sm font-semibold">Most Popular</span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Complete Inspection</h3>
                        <div class="text-4xl font-bold text-blue-600 mb-4">$199</div>
                        <p class="text-gray-600 mb-6">Comprehensive 13-point inspection</p>
                        <ul class="text-left space-y-3 mb-8">
                            <li><i class="fas fa-check text-green-500 mr-3"></i>All 13 inspection points</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Detailed PDF report</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Photo documentation</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Damage mapping</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Test drive included</li>
                        </ul>
                        <a href="{{ route('appointment.create', ['package' => 'complete']) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300 text-center">
                            Choose Complete
                        </a>
                    </div>
                </div>

                <!-- Premium Plus Package -->
                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Premium Plus</h3>
                        <div class="text-4xl font-bold text-blue-600 mb-4">$299</div>
                        <p class="text-gray-600 mb-6">Complete + Mobile service</p>
                        <ul class="text-left space-y-3 mb-8">
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Everything in Complete</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Mobile service (we come to you)</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Same-day report</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Priority scheduling</li>
                            <li><i class="fas fa-check text-green-500 mr-3"></i>Follow-up consultation</li>
                        </ul>
                        <a href="{{ route('appointment.create', ['package' => 'premium']) }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-semibold transition duration-300 text-center">
                            Choose Premium
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Get In Touch</h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Ready to schedule your inspection? Have questions about our services? 
                        We're here to help!
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Phone</h4>
                                <p class="text-gray-600">+1 (555) 123-4567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Email</h4>
                                <p class="text-gray-600">info@proinspect.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Location</h4>
                                <p class="text-gray-600">123 Main Street, City, State 12345</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Send us a message</h3>
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" name="first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" name="last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="tel" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-car text-2xl text-blue-400 mr-2"></i>
                        <span class="text-xl font-bold">ProInspect</span>
                    </div>
                    <p class="text-gray-400">
                        Professional vehicle inspection services you can trust. 
                        Get peace of mind with every inspection.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Vehicle Inspection</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Pre-Purchase Checks</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Mobile Service</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Fleet Inspections</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Our Team</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 ProInspect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth scrolling -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
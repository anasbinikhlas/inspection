<!-- Enhanced Navigation with Gradient Accent -->
<nav class="glass-effect shadow-lg fixed w-full z-50 border-b border-gray-100">
    <!-- Top Bar with Contact Info -->
    <div class="bg-gradient-primary text-white py-2 text-sm hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <a href="tel:+923001234567" class="flex items-center hover:text-blue-200 transition">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>+92 300 1234567</span>
                    </a>
                    <a href="mailto:info@proinspect.com" class="flex items-center hover:text-blue-200 transition">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>info@proinspect.com</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        Mon - Sat: 9:00 AM - 6:00 PM
                    </span>
                    <div class="flex space-x-3 ml-4">
                        <a href="#" class="hover:text-blue-200 transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-blue-200 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-blue-200 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-blue-200 transition"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <!-- Logo Section -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center group">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-blue-600 rounded-lg blur opacity-25 group-hover:opacity-40 transition"></div>
                            <div class="relative bg-gradient-primary p-2 rounded-lg">
                                <i class="fas fa-car-side text-2xl text-white"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">ProInspect</span>
                            <p class="text-xs text-gray-500 -mt-1">Professional Vehicle Inspection</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}" 
                   class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600 active' : '' }}">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                <a href="{{ route('home') }}#services" 
                   class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition duration-300">
                    <i class="fas fa-cogs mr-2"></i>Services
                </a>
                <a href="{{ route('home') }}#pricing" 
                   class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition duration-300">
                    <i class="fas fa-tags mr-2"></i>Pricing
                </a>
                <a href="{{ route('home') }}#contact" 
                   class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition duration-300">
                    <i class="fas fa-envelope mr-2"></i>Contact
                </a>
                <a href="{{ route('appointment.check-status') }}" 
                   class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition duration-300 {{ request()->routeIs('appointment.check-status') ? 'text-blue-600 active' : '' }}">
                    <i class="fas fa-search mr-2"></i>Check Status
                </a>
                
                <!-- CTA Button -->
                <a href="{{ route('appointment.schedule') }}" 
                   class="btn-primary ml-4 px-6 py-3 rounded-lg text-white font-semibold shadow-lg flex items-center space-x-2">
                    <i class="fas fa-calendar-check"></i>
                    <span>Book Now</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-gray-700 hover:text-blue-600 focus:outline-none transition">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="lg:hidden border-t border-gray-100 bg-white"
         style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('home') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                <i class="fas fa-home mr-3 w-5"></i>Home
            </a>
            <a href="{{ route('home') }}#services" 
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                <i class="fas fa-cogs mr-3 w-5"></i>Services
            </a>
            <a href="{{ route('home') }}#pricing" 
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                <i class="fas fa-tags mr-3 w-5"></i>Pricing
            </a>
            <a href="{{ route('home') }}#contact" 
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition">
                <i class="fas fa-envelope mr-3 w-5"></i>Contact
            </a>
            <a href="{{ route('appointment.check-status') }}" 
               class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition {{ request()->routeIs('appointment.check-status') ? 'bg-blue-50 text-blue-600' : '' }}">
                <i class="fas fa-search mr-3 w-5"></i>Check Status
            </a>
            <a href="{{ route('appointment.schedule') }}" 
               class="block mt-4 px-6 py-3 bg-gradient-primary text-white text-center rounded-lg font-semibold shadow-lg hover:shadow-xl transition">
                <i class="fas fa-calendar-check mr-2"></i>Book Appointment
            </a>
            
            <!-- Mobile Contact Info -->
            <div class="border-t border-gray-200 mt-4 pt-4 space-y-2">
                <a href="tel:+923001234567" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-phone-alt mr-3 w-5"></i>
                    <span>+92 300 1234567</span>
                </a>
                <a href="mailto:info@proinspect.com" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-envelope mr-3 w-5"></i>
                    <span>info@proinspect.com</span>
                </a>
            </div>

            <!-- Mobile Social Links -->
            <div class="flex justify-center space-x-6 pt-4 border-t border-gray-200 mt-4">
                <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fab fa-facebook-f text-xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fab fa-twitter text-xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fab fa-instagram text-xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-blue-600 transition"><i class="fab fa-linkedin-in text-xl"></i></a>
            </div>
        </div>
    </div>
</nav>
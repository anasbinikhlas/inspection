<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ProInspect') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Add x-cloak style to prevent flash -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    <!-- Alpine.js - Make sure it loads properly -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Additional Alpine.js initialization if needed -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure Alpine.js is ready
            if (typeof Alpine !== 'undefined') {
                console.log('Alpine.js loaded successfully');
            } else {
                console.error('Alpine.js failed to load');
            }
        });
    </script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 shadow-lg">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <div class="flex items-center">
                    <i class="fas fa-car text-2xl text-blue-400 mr-2"></i>
                    <span class="text-xl font-bold text-white">ProInspect Admin</span>
                </div>
            </div>
            
            <nav class="mt-5">
                <div class="px-2">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-white hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : '' }}">
                        <i class="fas fa-tachometer-alt mr-4 text-gray-300"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.appointments.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.appointments.*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-calendar-check mr-4"></i>
                        Appointments
                    </a>
                    
                    <a href="{{ route('admin.inspections.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.inspections.*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-clipboard-check mr-4"></i>
                        Inspections
                    </a>
                    
                    <a href="{{ route('admin.customers.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.customers.*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-users mr-4"></i>
                        Customers
                    </a>
                    
                    <a href="{{ route('admin.inspectors.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.inspectors.*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-user-tie mr-4"></i>
                        Inspectors
                    </a>
                    
                    <a href="{{ route('admin.locations.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.locations.*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-map-marker-alt mr-4"></i>
                        Locations
                    </a>
                    
                    <a href="{{ route('admin.reports') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.reports*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-chart-bar mr-4"></i>
                        Reports
                    </a>
                    
                    <a href="{{ route('admin.analytics') }}" class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.analytics*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-analytics mr-4"></i>
                        Analytics
                    </a>

                    <!-- Separator -->
                    <div class="my-4 border-t border-gray-700"></div>
                    
                    <a href="{{ route('admin.settings') }}" class="group flex items-center px-2 py-2 text-base leading-6 font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150 {{ request()->routeIs('admin.settings*') ? 'bg-gray-900 text-white' : '' }}">
                        <i class="fas fa-cog mr-4"></i>
                        Settings
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            @yield('header', 'Dashboard')
                        </h1>
                        @hasSection('breadcrumbs')
                            <nav class="text-sm">
                                @yield('breadcrumbs')
                            </nav>
                        @endif
                    </div>

                    <!-- User Menu - Fixed Alpine.js implementation -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button 
                            @click.stop="open = !open" 
                            type="button"
                            class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md px-2 py-1"
                            :aria-expanded="open.toString()"
                            aria-haspopup="true"
                        >
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&color=7F9CF5&background=EBF4FF" alt="User avatar">
                            <span class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div 
                            x-show="open" 
                            x-cloak
                            @keydown.escape.window="open = false"
                            x-transition:enter="transition ease-out duration-100" 
                            x-transition:enter-start="transform opacity-0 scale-95" 
                            x-transition:enter-end="transform opacity-100 scale-100" 
                            x-transition:leave="transition ease-in duration-75" 
                            x-transition:leave-start="transform opacity-100 scale-100" 
                            x-transition:leave-end="transform opacity-0 scale-95" 
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5"
                        >
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                <i class="fas fa-external-link-alt mr-2"></i>View Website
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button @click="show = false" type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 hover:bg-green-200 transition-colors duration-150">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded relative">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button @click="show = false" type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 hover:bg-red-200 transition-colors duration-150">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')
    
    <!-- Debug Alpine.js -->
    <script>
        // Debug script to check if Alpine.js is working
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized successfully');
        });
    </script>
</body>
</html>
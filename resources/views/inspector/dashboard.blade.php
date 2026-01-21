@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Inspector Dashboard</h1>
                    <p class="text-gray-600 mt-1">Welcome, {{ Auth::user()->name }}</p>
                </div>
                <div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">Total Inspections</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalInspections }}</p>
                    </div>
                    <div class="text-4xl text-blue-500">📋</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">In Progress</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $inProgressCount }}</p>
                    </div>
                    <div class="text-4xl text-yellow-500">⏳</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-green-600">{{ $completedCount }}</p>
                    </div>
                    <div class="text-4xl text-green-500">✅</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">Pending Review</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $pendingReviewCount }}</p>
                    </div>
                    <div class="text-4xl text-orange-500">🔍</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('inspector.inspections.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-gray-900 mb-2">My Inspections</h3>
                <p class="text-gray-600 text-sm">View and manage your assigned inspections</p>
                <div class="mt-4 text-blue-600">→ View All</div>
            </a>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Schedule</h3>
                <p class="text-gray-600 text-sm">Check your inspection schedule</p>
                <div class="mt-4 text-blue-600">→ Coming Soon</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Statistics</h3>
                <p class="text-gray-600 text-sm">View your performance metrics</p>
                <div class="mt-4 text-blue-600">→ Coming Soon</div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Recent Inspections</h2>
            </div>
            <div class="p-6">
                @if($recentInspections->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentInspections as $inspection)
                            <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $inspection->appointment->appointment_number ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">{{ $inspection->appointment->vehicle_year ?? '' }} {{ $inspection->appointment->vehicle_make ?? '' }} {{ $inspection->appointment->vehicle_model ?? '' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium">
                                        @if($inspection->status === 'IN_PROGRESS')
                                            <span class="text-yellow-600">⏳ In Progress</span>
                                        @elseif($inspection->status === 'COMPLETED')
                                            <span class="text-orange-600">🔍 Pending Review</span>
                                        @elseif($inspection->status === 'REVIEWED')
                                            <span class="text-green-600">✅ Approved</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $inspection->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-center py-8">No inspections yet. Check back soon!</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
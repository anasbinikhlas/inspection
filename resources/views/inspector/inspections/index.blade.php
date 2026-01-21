@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-x-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Inspections</h1>
                    <p class="text-gray-600 mt-1">View and manage your assigned inspections</p>
                </div>
                <a href="{{ route('inspector.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    ← Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Tabs -->
        <div class="mb-6 flex gap-4">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">All</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50">In Progress</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50">Completed</button>
            <button class="px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-50">Rejected</button>
        </div>

        <!-- Inspections List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($inspections as $inspection)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('inspector.inspections.perform', $inspection->id) }}'">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $inspection->appointment->appointment_number ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $inspection->appointment->vehicle_year ?? '' }} {{ $inspection->appointment->vehicle_make ?? '' }} {{ $inspection->appointment->vehicle_model ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $inspection->appointment->customer->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($inspection->status === 'IN_PROGRESS')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">⏳ In Progress</span>
                                @elseif($inspection->status === 'COMPLETED')
                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-medium">🔍 Pending Review</span>
                                @elseif($inspection->status === 'REVIEWED')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">✅ Approved</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $inspection->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('inspector.inspections.perform', $inspection->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                    @if($inspection->status === 'IN_PROGRESS')
                                        Continue →
                                    @else
                                        View →
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-600">
                                No inspections assigned yet. Check back soon!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Empty State with Call to Action -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-4">No inspections have been assigned to you yet.</p>
            <p class="text-sm text-gray-500">Your admin will assign inspections here as they come in.</p>
        </div>
    </div>
</div>
@endsection
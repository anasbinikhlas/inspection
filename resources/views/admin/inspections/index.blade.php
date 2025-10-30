@extends('layouts.admin')

@section('header', 'Inspections')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Inspections</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-spinner text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">In Progress</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['in_progress']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['completed']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-star text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Avg Score</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['avg_score'], 1) }}%</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('admin.inspections.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Inspection #, Vehicle..."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" 
                                id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </div>

                    <!-- Condition Filter -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700">Condition</label>
                        <select name="condition" 
                                id="condition"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Conditions</option>
                            <option value="excellent" {{ request('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                            <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                            <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                            <option value="poor" {{ request('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                            <option value="needs_attention" {{ request('condition') == 'needs_attention' ? 'selected' : '' }}>Needs Attention</option>
                        </select>
                    </div>

                    <!-- Inspector Filter -->
                    <div>
                        <label for="inspector_id" class="block text-sm font-medium text-gray-700">Inspector</label>
                        <select name="inspector_id" 
                                id="inspector_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Inspectors</option>
                            @foreach($inspectors as $inspector)
                                <option value="{{ $inspector->id }}" {{ request('inspector_id') == $inspector->id ? 'selected' : '' }}>
                                    {{ $inspector->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.inspections.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-redo mr-2"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Inspections Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            @if($inspections->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Inspection #
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vehicle
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Inspector
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Score
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Condition
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recommendation
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="relative px-3 py-3.5">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($inspections as $inspection)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $inspection->inspection_number }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $inspection->appointment->appointment_number }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $inspection->appointment->vehicle_full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst($inspection->appointment->vehicle_type) }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $inspection->appointment->customer->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $inspection->appointment->customer->phone }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $inspection->inspector->full_name }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ number_format($inspection->overall_score, 1) }}%
                                            </div>
                                            <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-{{ $inspection->overall_score >= 80 ? 'green' : ($inspection->overall_score >= 60 ? 'yellow' : 'red') }}-500 h-2 rounded-full" 
                                                     style="width: {{ $inspection->overall_score }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $inspection->overall_condition_color }}-100 text-{{ $inspection->overall_condition_color }}-800 capitalize">
                                            {{ str_replace('_', ' ', $inspection->overall_condition) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $inspection->recommendation_color }}-100 text-{{ $inspection->recommendation_color }}-800 capitalize">
                                            {{ str_replace('_', ' ', $inspection->recommendation) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $inspection->status_color }}-100 text-{{ $inspection->status_color }}-800 capitalize">
                                            {{ str_replace('_', ' ', $inspection->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $inspection->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.inspections.show', $inspection) }}" 
                                               class="text-blue-600 hover:text-blue-900"
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.inspections.edit', $inspection) }}" 
                                               class="text-yellow-600 hover:text-yellow-900"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.inspections.pdf', $inspection) }}" 
                                               class="text-green-600 hover:text-green-900"
                                               title="Download PDF"
                                               target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <form action="{{ route('admin.inspections.destroy', $inspection) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this inspection?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $inspections->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No inspections found</h3>
                    <p class="text-gray-500">
                        @if(request()->hasAny(['search', 'status', 'condition', 'inspector_id']))
                            Try adjusting your filters to find what you're looking for.
                        @else
                            Inspections will appear here once they are completed.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('header', 'Appointments')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Appointments -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate uppercase">Total</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $appointments->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-md transition" onclick="window.location='{{ route('admin.appointments.index', ['status' => 'pending']) }}'">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate uppercase">Pending</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $statusCounts['pending'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmed -->
        <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-md transition" onclick="window.location='{{ route('admin.appointments.index', ['status' => 'confirmed']) }}'">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-check-circle text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate uppercase">Confirmed</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $statusCounts['confirmed'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-md transition" onclick="window.location='{{ route('admin.appointments.index', ['status' => 'in_progress']) }}'">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-spinner text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate uppercase">In Progress</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $statusCounts['in_progress'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-md transition" onclick="window.location='{{ route('admin.appointments.index', ['status' => 'completed']) }}'">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-check-double text-white"></i>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-xs font-medium text-gray-500 truncate uppercase">Completed</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $statusCounts['completed'] ?? 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('admin.appointments.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               value="{{ request('search') }}"
                               placeholder="Name, Phone, Appointment #..."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" 
                                id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="no_show" {{ request('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                        <input type="date" 
                               name="date_from" 
                               id="date_from" 
                               value="{{ request('date_from') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                        <input type="date" 
                               name="date_to" 
                               id="date_to" 
                               value="{{ request('date_to') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>

                    <!-- Source Filter -->
                    <div>
                        <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                        <select name="source" 
                                id="source"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Sources</option>
                            <option value="admin" {{ request('source') == 'admin' ? 'selected' : '' }}>Admin Created</option>
                            <option value="frontend" {{ request('source') == 'frontend' ? 'selected' : '' }}>Client Booking</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-redo mr-2"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                @if(request('status'))
                    {{ ucfirst(str_replace('_', ' ', request('status'))) }} Appointments
                @else
                    All Appointments
                @endif
            </h3>
            <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                New Appointment
            </a>
        </div>

        <div class="px-4 py-5 sm:p-6">
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Appointment
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vehicle
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date & Time
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Inspector
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Package
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="relative px-3 py-3.5">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $appointment->appointment_number }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $appointment->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $appointment->customer->full_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->customer->phone }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $appointment->vehicle_full_name }}</div>
                                        <div class="text-xs text-gray-500 capitalize">{{ $appointment->vehicle_type }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $appointment->appointment_time->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $appointment->location->name }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        @if($appointment->inspector)
                                            <div class="text-sm text-gray-900">{{ $appointment->inspector->full_name }}</div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Not assigned</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                            {{ $appointment->package_type }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800 capitalize">
                                            {{ str_replace('_', ' ', $appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $appointment->formatted_price }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- View -->
                                            <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                               class="text-blue-600 hover:text-blue-900"
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.appointments.edit', $appointment) }}" 
                                               class="text-yellow-600 hover:text-yellow-900"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if($appointment->status === 'pending')
                                                <!-- Confirm -->
                                                <form action="{{ route('admin.appointments.confirm', $appointment) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900"
                                                            title="Confirm Appointment">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($appointment->status === 'confirmed' && !$appointment->inspector_id)
                                                <!-- Assign Inspector -->
                                                <button onclick="openAssignModal({{ $appointment->id }})"
                                                        class="text-purple-600 hover:text-purple-900"
                                                        title="Assign Inspector">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            @endif

                                            @if($appointment->status === 'confirmed' || $appointment->status === 'in_progress')
                                                @if(!$appointment->inspection)
                                                    <!-- Create Inspection -->
                                                    <a href="{{ route('admin.inspections.create', $appointment) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900"
                                                       title="Create Inspection">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </a>
                                                @else
                                                    <!-- View Inspection -->
                                                    <a href="{{ route('admin.inspections.show', $appointment->inspection) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900"
                                                       title="View Inspection">
                                                        <i class="fas fa-clipboard-list"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            @if(in_array($appointment->status, ['pending', 'confirmed']))
                                                <!-- Cancel -->
                                                <form action="{{ route('admin.appointments.cancel', $appointment) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900"
                                                            title="Cancel Appointment">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete -->
                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this appointment? This action cannot be undone.');">
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
                    {{ $appointments->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No appointments found</h3>
                    <p class="text-gray-500 mb-4">
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            Try adjusting your filters to find what you're looking for.
                        @else
                            Get started by creating your first appointment.
                        @endif
                    </p>
                    <a href="{{ route('admin.appointments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Create Appointment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Assign Inspector Modal -->
<div id="assignModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="assignForm" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Inspector</h3>
                    <div>
                        <label for="inspector_id" class="block text-sm font-medium text-gray-700">Select Inspector</label>
                        <select name="inspector_id" id="inspector_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                            <option value="">Choose an inspector...</option>
                            @foreach($inspectors ?? [] as $inspector)
                                <option value="{{ $inspector->id }}">{{ $inspector->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Assign
                    </button>
                    <button type="button" onclick="closeAssignModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAssignModal(appointmentId) {
    const modal = document.getElementById('assignModal');
    const form = document.getElementById('assignForm');
    form.action = `/admin/appointments/${appointmentId}/assign-inspector`;
    modal.classList.remove('hidden');
}

function closeAssignModal() {
    const modal = document.getElementById('assignModal');
    modal.classList.add('hidden');
}
</script>
@endpush
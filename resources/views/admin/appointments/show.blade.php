@extends('layouts.admin')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">Appointment Details</h2>
            <p class="text-gray-600 text-sm mt-1">{{ $appointment->appointment_number }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.appointments.edit', $appointment) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="{{ route('admin.appointments.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Status Card -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Current Status</h3>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800 capitalize">
                    <i class="fas fa-circle mr-2 text-xs"></i>
                    {{ str_replace('_', ' ', $appointment->status) }}
                </span>
            </div>
            
            <div class="flex space-x-2">
                @if($appointment->status === 'pending')
                    <form action="{{ route('admin.appointments.confirm', $appointment) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            Confirm
                        </button>
                    </form>
                @endif

                @if(in_array($appointment->status, ['pending', 'confirmed']))
                    <form action="{{ route('admin.appointments.cancel', $appointment) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-times-circle mr-2"></i>
                            Cancel
                        </button>
                    </form>
                @endif

                @if($appointment->status === 'confirmed' || $appointment->status === 'in_progress')
                    @if(!$appointment->inspection)
                        <a href="{{ route('admin.inspections.create', $appointment) }}" 
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-clipboard-check mr-2"></i>
                            Create Inspection
                        </a>
                    @else
                        <a href="{{ route('admin.inspections.show', $appointment->inspection) }}" 
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            View Inspection
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $appointment->customer->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="tel:{{ $appointment->customer->phone }}" class="text-blue-600 hover:text-blue-700">
                                    {{ $appointment->customer->phone }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $appointment->customer->email }}" class="text-blue-600 hover:text-blue-700">
                                    {{ $appointment->customer->email }}
                                </a>
                            </dd>
                        </div>
                        @if($appointment->customer->address)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $appointment->customer->address }}<br>
                                {{ $appointment->customer->city }}, {{ $appointment->customer->zip_code }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                    <div class="mt-4">
                        <a href="{{ route('admin.customers.show', $appointment->customer) }}" 
                           class="text-sm text-blue-600 hover:text-blue-700">
                            View Customer Profile →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Vehicle Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Vehicle</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $appointment->vehicle_full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $appointment->vehicle_type }}</dd>
                        </div>
                        @if($appointment->color)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Color</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $appointment->color }}</dd>
                        </div>
                        @endif
                        @if($appointment->mileage)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Mileage</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($appointment->mileage) }} miles</dd>
                        </div>
                        @endif
                        @if($appointment->vin)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">VIN</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $appointment->vin }}</dd>
                        </div>
                        @endif
                        @if($appointment->license_plate)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">License Plate</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $appointment->license_plate }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Notes -->
            @if($appointment->customer_notes || $appointment->admin_notes)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Notes</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    @if($appointment->customer_notes)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Customer Notes</dt>
                        <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $appointment->customer_notes }}</dd>
                    </div>
                    @endif
                    @if($appointment->admin_notes)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-1">Admin Notes (Internal)</dt>
                        <dd class="text-sm text-gray-900 bg-yellow-50 p-3 rounded border border-yellow-200">{{ $appointment->admin_notes }}</dd>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Appointment Details -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Appointment Details</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                            {{ $appointment->appointment_date->format('l, F j, Y') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Time</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                            {{ $appointment->appointment_time->format('g:i A') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                        <dd class="mt-1 text-sm text-gray-900">~{{ $appointment->estimated_duration }} minutes</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Package</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 capitalize">
                                {{ $appointment->package_type }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                        <dd class="mt-1 text-lg text-gray-900 font-bold">{{ $appointment->formatted_price }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Source</dt>
                        <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $appointment->source ?? 'frontend' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Location</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="text-sm text-gray-900 font-semibold mb-2">{{ $appointment->location->name }}</div>
                    <div class="text-sm text-gray-600">
                        {{ $appointment->location->address }}<br>
                        {{ $appointment->location->city }}, {{ $appointment->location->state }} {{ $appointment->location->zip_code }}
                    </div>
                    @if($appointment->location->phone)
                    <div class="mt-2">
                        <a href="tel:{{ $appointment->location->phone }}" class="text-sm text-blue-600 hover:text-blue-700">
                            {{ $appointment->location->phone }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Inspector -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Inspector</h3>
                    @if($appointment->status === 'confirmed' && !$appointment->inspector_id)
                        <button onclick="openAssignModal({{ $appointment->id }})"
                                class="text-sm text-blue-600 hover:text-blue-700">
                            <i class="fas fa-plus mr-1"></i>
                            Assign
                        </button>
                    @endif
                </div>
                <div class="px-6 py-4">
                    @if($appointment->inspector)
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $appointment->inspector->full_name }}</div>
                                <div class="text-sm text-gray-600">{{ $appointment->inspector->phone }}</div>
                                @if($appointment->inspector->email)
                                <div class="text-xs text-gray-500">{{ $appointment->inspector->email }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.inspectors.show', $appointment->inspector) }}" 
                               class="text-sm text-blue-600 hover:text-blue-700">
                                View Profile →
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">No inspector assigned yet</p>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Timeline</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                <i class="fas fa-plus text-white text-xs"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm text-gray-900 font-medium">Created</div>
                                            <div class="text-xs text-gray-500">{{ $appointment->created_at->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if($appointment->updated_at != $appointment->created_at)
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center">
                                                <i class="fas fa-edit text-white text-xs"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm text-gray-900 font-medium">Last Updated</div>
                                            <div class="text-xs text-gray-500">{{ $appointment->updated_at->format('M d, Y g:i A') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign Inspector Modal (if needed) -->
<div id="assignModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="assignForm" method="POST" action="{{ route('admin.appointments.assign-inspector', $appointment) }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Inspector</h3>
                    <div>
                        <label for="inspector_id" class="block text-sm font-medium text-gray-700">Select Inspector</label>
                        <select name="inspector_id" id="inspector_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                            <option value="">Choose an inspector...</option>
                            @foreach(\App\Models\Inspector::where('status', 'active')->get() as $inspector)
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
    modal.classList.remove('hidden');
}

function closeAssignModal() {
    const modal = document.getElementById('assignModal');
    modal.classList.add('hidden');
}
</script>
@endpush
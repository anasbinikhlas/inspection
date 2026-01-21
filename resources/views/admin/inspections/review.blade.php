@extends('layouts.admin')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">Review Inspection</h2>
            <p class="text-gray-600 text-sm mt-1">{{ $inspection->inspection_number }}</p>
        </div>
        <a href="{{ route('admin.inspections.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to List
        </a>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Inspection Status -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Inspection Status</h3>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-orange-100 text-orange-800">
                    <i class="fas fa-circle mr-2 text-xs"></i>
                    Pending Review
                </span>
            </div>
            <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Inspector</dt>
                    <dd class="text-sm text-gray-900 font-semibold mt-1">{{ $inspection->inspector->full_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Submitted Date</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $inspection->completed_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Vehicle</dt>
                    <dd class="text-sm text-gray-900 font-semibold mt-1">{{ $inspection->appointment->vehicle_year }} {{ $inspection->appointment->vehicle_make }} {{ $inspection->appointment->vehicle_model }}</dd>
                </div>
            </dl>
        </div>

        <!-- Inspection Scores & Details -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Inspection Scores</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="p-3 bg-gray-50 rounded">
                    <dt class="text-xs font-medium text-gray-500">Engine</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspection->engine_transmission_score ?? 'N/A' }}</dd>
                </div>
                <div class="p-3 bg-gray-50 rounded">
                    <dt class="text-xs font-medium text-gray-500">Brakes</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspection->brakes_score ?? 'N/A' }}</dd>
                </div>
                <div class="p-3 bg-gray-50 rounded">
                    <dt class="text-xs font-medium text-gray-500">Suspension</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspection->suspension_steering_score ?? 'N/A' }}</dd>
                </div>
                <div class="p-3 bg-gray-50 rounded">
                    <dt class="text-xs font-medium text-gray-500">Interior</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspection->interior_score ?? 'N/A' }}</dd>
                </div>
                <div class="p-3 bg-gray-50 rounded">
                    <dt class="text-xs font-medium text-gray-500">Electrical</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspection->electrical_score ?? 'N/A' }}</dd>
                </div>
                <div class="p-3 bg-gray-50 rounded">
                    <dt class="text-xs font-medium text-gray-500">Tires</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspection->tyres_score ?? 'N/A' }}</dd>
                </div>
            </div>
        </div>

        <!-- Overall Condition & Recommendation -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Assessment</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-700 mb-2">Overall Condition</dt>
                    <dd class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ 'bg-' . $inspection->overall_condition_color . '-100 text-' . $inspection->overall_condition_color . '-800' }}">
                        {{ ucfirst(str_replace('_', ' ', $inspection->overall_condition)) }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-700 mb-2">Recommendation</dt>
                    <dd class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ 'bg-' . $inspection->recommendation_color . '-100 text-' . $inspection->recommendation_color . '-800' }}">
                        {{ ucfirst(str_replace('_', ' ', $inspection->recommendation)) }}
                    </dd>
                </div>
            </div>
        </div>

        <!-- Issues & Notes -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-3">Major Issues</h3>
                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">
                    {{ $inspection->major_issues ?? 'No major issues found' }}
                </p>
            </div>
            <div class="border-t pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Minor Issues</h3>
                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">
                    {{ $inspection->minor_issues ?? 'No minor issues found' }}
                </p>
            </div>
            <div class="border-t pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Recommendations</h3>
                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">
                    {{ $inspection->recommendations ?? 'No specific recommendations' }}
                </p>
            </div>
        </div>

        <!-- Cost Estimates -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Cost Estimates</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-700">Immediate Repairs</dt>
                    <dd class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($inspection->immediate_repairs_cost ?? 0, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-700">Future Maintenance</dt>
                    <dd class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($inspection->future_maintenance_cost ?? 0, 2) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Sidebar - Actions -->
    <div class="space-y-6">
        <!-- Approve Button -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Inspection</h3>
            <p class="text-sm text-gray-600 mb-4">Click below to approve this inspection and make it available to the client.</p>
            <form action="{{ route('admin.inspections.approve', $inspection) }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                    <i class="fas fa-check-circle mr-2"></i>
                    Approve Inspection
                </button>
            </form>
        </div>

        <!-- Reject Button -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Inspection</h3>
            <p class="text-sm text-gray-600 mb-4">Send this inspection back to the inspector for corrections.</p>
            <button onclick="openRejectModal()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                <i class="fas fa-times-circle mr-2"></i>
                Reject & Send Back
            </button>
        </div>

        <!-- Edit & Approve Button -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit & Approve</h3>
            <p class="text-sm text-gray-600 mb-4">Make corrections and approve in one action.</p>
            <a href="{{ route('admin.inspections.edit', $inspection) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                <i class="fas fa-edit mr-2"></i>
                Edit Details
            </a>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.inspections.reject', $inspection) }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Inspection</h3>
                    <p class="text-sm text-gray-600 mb-4">Provide detailed feedback for the inspector to address.</p>
                    <div>
                        <label for="rejection_notes" class="block text-sm font-medium text-gray-700 mb-2">Rejection Notes *</label>
                        <textarea name="rejection_notes" id="rejection_notes" rows="5" required
                                  placeholder="Describe what needs to be corrected or improved..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Minimum 10 characters required</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Send Back to Inspector
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endpush
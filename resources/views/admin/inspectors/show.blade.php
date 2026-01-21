@extends('layouts.admin')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">{{ $inspector->full_name }}</h2>
            <p class="text-gray-600 text-sm mt-1">{{ $inspector->employee_id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.inspectors.edit', $inspector) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="{{ route('admin.inspectors.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Status Card -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Current Status</h3>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $inspector->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        <i class="fas fa-circle mr-2 text-xs"></i>
                        {{ ucfirst($inspector->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
            </div>
            <div class="px-6 py-4">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $inspector->employee_id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $inspector->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="tel:{{ $inspector->phone }}" class="text-blue-600 hover:text-blue-900">
                                {{ $inspector->phone }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $inspector->hire_date->format('F j, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Admin View Only Section -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    Admin View Only
                </h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 mb-1">Email</dt>
                    <dd class="text-sm text-gray-900">
                        @if($inspector->email)
                            <a href="mailto:{{ $inspector->email }}" class="text-blue-600 hover:text-blue-900">
                                {{ $inspector->email }}
                            </a>
                        @else
                            <span class="text-gray-400 italic">Not provided</span>
                        @endif
                    </dd>
                </div>

                <div class="border-t pt-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Identity Card #</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $inspector->identity_card ?? 'Not provided' }}
                    </dd>
                </div>

                <div class="border-t pt-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Residence Address</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $inspector->residence_address ?? 'Not provided' }}
                    </dd>
                </div>

                <div class="border-t pt-4">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Marital Status</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $inspector->marital_status ? ucfirst($inspector->marital_status) : 'Not provided' }}
                    </dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Info</h3>
            <dl class="space-y-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Inspections</dt>
                    <dd class="text-2xl font-bold text-gray-900">{{ $inspector->inspections->count() }}</dd>
                </div>
                <div class="border-t pt-4">
                    <dt class="text-xs font-medium text-gray-500 uppercase">Hourly Rate</dt>
                    <dd class="text-lg text-gray-900">${{ number_format($inspector->hourly_rate, 2) }}</dd>
                </div>
                <div class="border-t pt-4">
                    <dt class="text-xs font-medium text-gray-500 uppercase">Member Since</dt>
                    <dd class="text-sm text-gray-900">{{ $inspector->created_at->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.inspectors.edit', $inspector) }}" class="block w-full text-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Inspector
                </a>
                <form action="{{ route('admin.inspectors.destroy', $inspector) }}" method="POST" 
                      onsubmit="return confirm('Are you sure? This will also delete the user account.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block w-full px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Inspector
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
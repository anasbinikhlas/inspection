@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Perform Inspection</h1>
                    <p class="text-gray-600 mt-1">Fill in the inspection details for this vehicle</p>
                </div>
                <a href="{{ route('inspector.inspections.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    ← Back
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="{{ route('inspector.inspections.submit', $inspection->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Vehicle Information (Read-only) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Vehicle Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vehicle Year/Make/Model</label>
                        <input type="text" disabled value="{{ $inspection->appointment->vehicle_year }} {{ $inspection->appointment->vehicle_make }} {{ $inspection->appointment->vehicle_model }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">License Plate</label>
                        <input type="text" disabled value="{{ $inspection->appointment->license_plate }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">VIN</label>
                        <input type="text" disabled value="{{ $inspection->appointment->vin }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mileage</label>
                        <input type="text" disabled value="{{ number_format($inspection->appointment->mileage) }} km" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                </div>
            </div>

            <!-- Inspection Scores -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Inspection Scores (1-10)</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Engine Condition</label>
                        <input type="number" name="engine_score" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Brakes</label>
                        <input type="number" name="brakes_score" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transmission</label>
                        <input type="number" name="transmission_score" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suspension</label>
                        <input type="number" name="suspension_score" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Electrical</label>
                        <input type="number" name="electrical_score" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tires</label>
                        <input type="number" name="tires_score" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Overall Condition -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Overall Condition</h2>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="excellent" class="rounded-full">
                        <span class="ml-3 text-gray-700">Excellent - Like New</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="good" class="rounded-full">
                        <span class="ml-3 text-gray-700">Good - Minor Issues</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="fair" class="rounded-full">
                        <span class="ml-3 text-gray-700">Fair - Moderate Issues</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="poor" class="rounded-full">
                        <span class="ml-3 text-gray-700">Poor - Significant Issues</span>
                    </label>
                </div>
            </div>

            <!-- Major Issues -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Major Issues Found</h2>
                <textarea name="major_issues" rows="4" placeholder="List any major issues found during inspection..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Minor Issues -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Minor Issues Found</h2>
                <textarea name="minor_issues" rows="4" placeholder="List any minor issues found..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Recommendations -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Recommendations</h2>
                <textarea name="recommendations" rows="4" placeholder="Provide recommendations for repair or maintenance..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Cost Estimates -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Cost Estimates</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Repair Cost</label>
                        <div class="flex items-center">
                            <span class="text-gray-500">$</span>
                            <input type="number" name="repair_cost" step="0.01" placeholder="0.00" class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Parts Cost (if known)</label>
                        <div class="flex items-center">
                            <span class="text-gray-500">$</span>
                            <input type="number" name="parts_cost" step="0.01" placeholder="0.00" class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Drive Notes -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Test Drive Notes</h2>
                <textarea name="test_drive_notes" rows="4" placeholder="Document any issues found during test drive..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Photo Upload -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Upload Photos</h2>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <input type="file" name="photos[]" multiple accept="image/*" class="hidden" id="photo-input">
                    <label for="photo-input" class="cursor-pointer">
                        <div class="text-4xl text-gray-400 mb-2">📷</div>
                        <p class="text-gray-600">Click to upload photos or drag and drop</p>
                        <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6 flex gap-4">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Submit for Review
                </button>
                <button type="button" onclick="window.history.back()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
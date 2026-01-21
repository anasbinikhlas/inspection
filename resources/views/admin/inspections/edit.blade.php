@extends('layouts.admin')

@section('header', 'Edit Inspection')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.inspections.update', $inspection) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Inspection Info (Read-only) -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Inspection Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Inspection #</label>
                            <input type="text" disabled value="{{ $inspection->inspection_number }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Inspector</label>
                            <select name="inspector_id" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                @foreach($inspectors as $inspector)
                                    <option value="{{ $inspector->id }}" {{ $inspection->inspector_id == $inspector->id ? 'selected' : '' }}>
                                        {{ $inspector->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="in_progress" {{ $inspection->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $inspection->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="reviewed" {{ $inspection->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="delivered" {{ $inspection->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Inspection Scores -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Inspection Scores (0-100)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Engine/Transmission</label>
                            <input type="number" name="engine_transmission_score" min="0" max="100" step="0.1" value="{{ $inspection->engine_transmission_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Brakes</label>
                            <input type="number" name="brakes_score" min="0" max="100" step="0.1" value="{{ $inspection->brakes_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Suspension/Steering</label>
                            <input type="number" name="suspension_steering_score" min="0" max="100" step="0.1" value="{{ $inspection->suspension_steering_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Interior</label>
                            <input type="number" name="interior_score" min="0" max="100" step="0.1" value="{{ $inspection->interior_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">AC/Heater</label>
                            <input type="number" name="ac_heater_score" min="0" max="100" step="0.1" value="{{ $inspection->ac_heater_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Electrical</label>
                            <input type="number" name="electrical_score" min="0" max="100" step="0.1" value="{{ $inspection->electrical_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Exterior/Body</label>
                            <input type="number" name="exterior_body_score" min="0" max="100" step="0.1" value="{{ $inspection->exterior_body_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tires</label>
                            <input type="number" name="tyres_score" min="0" max="100" step="0.1" value="{{ $inspection->tyres_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Frame</label>
                            <input type="number" name="frame_score" min="0" max="100" step="0.1" value="{{ $inspection->frame_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Test Drive</label>
                            <input type="number" name="test_drive_score" min="0" max="100" step="0.1" value="{{ $inspection->test_drive_score }}" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Overall Assessment -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Assessment</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Overall Condition *</label>
                            <select name="overall_condition" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="excellent" {{ $inspection->overall_condition == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ $inspection->overall_condition == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ $inspection->overall_condition == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ $inspection->overall_condition == 'poor' ? 'selected' : '' }}>Poor</option>
                                <option value="needs_attention" {{ $inspection->overall_condition == 'needs_attention' ? 'selected' : '' }}>Needs Attention</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recommendation *</label>
                            <select name="recommendation" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="buy" {{ $inspection->recommendation == 'buy' ? 'selected' : '' }}>Buy</option>
                                <option value="negotiate" {{ $inspection->recommendation == 'negotiate' ? 'selected' : '' }}>Negotiate</option>
                                <option value="minor_repairs" {{ $inspection->recommendation == 'minor_repairs' ? 'selected' : '' }}>Minor Repairs</option>
                                <option value="major_repairs" {{ $inspection->recommendation == 'major_repairs' ? 'selected' : '' }}>Major Repairs</option>
                                <option value="avoid" {{ $inspection->recommendation == 'avoid' ? 'selected' : '' }}>Avoid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Issues & Notes -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Issues & Notes</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Major Issues</label>
                            <textarea name="major_issues" rows="3" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $inspection->major_issues }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minor Issues</label>
                            <textarea name="minor_issues" rows="3" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $inspection->minor_issues }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recommendations</label>
                            <textarea name="recommendations" rows="3" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $inspection->recommendations }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Cost Estimates -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cost Estimates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Immediate Repairs Cost</label>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-500">$</span>
                                <input type="number" name="immediate_repairs_cost" step="0.01" value="{{ $inspection->immediate_repairs_cost }}" class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Future Maintenance Cost</label>
                            <div class="flex items-center mt-1">
                                <span class="text-gray-500">$</span>
                                <input type="number" name="future_maintenance_cost" step="0.01" value="{{ $inspection->future_maintenance_cost }}" class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.inspections.show', $inspection) }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Update Inspection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
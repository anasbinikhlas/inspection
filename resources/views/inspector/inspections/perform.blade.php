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
            @php($isReadOnly = $inspection->status !== 'in_progress')

            @if(!empty($inspection->rejection_notes) || !empty($inspection->rejected_at))
            <div class="rounded-lg border border-red-300 bg-red-50 p-4">
                <div class="flex items-start">
                    <div class="mr-3 text-red-600 text-lg">!</div>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800">Inspection Was Rejected</h3>
                        @if(!empty($inspection->rejected_at))
                        <p class="mt-1 text-sm text-red-700">
                            Rejected on {{ optional($inspection->rejected_at)->format('M d, Y h:i A') }}
                        </p>
                        @endif
                        @if(!empty($inspection->rejection_notes))
                        <p class="mt-2 text-sm text-red-700 whitespace-pre-line">{{ $inspection->rejection_notes }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

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
                        <input type="number" name="engine_score" min="1" max="10" value="{{ old('engine_score', $inspection->engine_transmission_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Brakes</label>
                        <input type="number" name="brakes_score" min="1" max="10" value="{{ old('brakes_score', $inspection->brakes_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suspension & Steering</label>
                        <input type="number" name="suspension_steering_score" min="1" max="10" value="{{ old('suspension_steering_score', $inspection->suspension_steering_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Interior</label>
                        <input type="number" name="interior_score" min="1" max="10" value="{{ old('interior_score', $inspection->interior_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">AC & Heater</label>
                        <input type="number" name="ac_heater_score" min="1" max="10" value="{{ old('ac_heater_score', $inspection->ac_heater_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Electrical</label>
                        <input type="number" name="electrical_score" min="1" max="10" value="{{ old('electrical_score', $inspection->electrical_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Exterior & Body</label>
                        <input type="number" name="exterior_body_score" min="1" max="10" value="{{ old('exterior_body_score', $inspection->exterior_body_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tyres</label>
                        <input type="number" name="tyres_score" min="1" max="10" value="{{ old('tyres_score', $inspection->tyres_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Frame</label>
                        <input type="number" name="frame_score" min="1" max="10" value="{{ old('frame_score', $inspection->frame_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Test Drive</label>
                        <input type="number" name="test_drive_score" min="1" max="10" value="{{ old('test_drive_score', $inspection->test_drive_score ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Overall Condition -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Overall Condition</h2>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="excellent" {{ old('overall_condition', $inspection->overall_condition) === 'excellent' ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }} class="rounded-full">
                        <span class="ml-3 text-gray-700">Excellent - Like New</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="good" {{ old('overall_condition', $inspection->overall_condition) === 'good' ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }} class="rounded-full">
                        <span class="ml-3 text-gray-700">Good - Minor Issues</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="fair" {{ old('overall_condition', $inspection->overall_condition) === 'fair' ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }} class="rounded-full">
                        <span class="ml-3 text-gray-700">Fair - Moderate Issues</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="poor" {{ old('overall_condition', $inspection->overall_condition) === 'poor' ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }} class="rounded-full">
                        <span class="ml-3 text-gray-700">Poor - Significant Issues</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="overall_condition" value="needs_attention" {{ old('overall_condition', $inspection->overall_condition) === 'needs_attention' ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }} class="rounded-full">
                        <span class="ml-3 text-gray-700">Needs Attention - Critical Issues</span>
                    </label>
                </div>
            </div>

            <!-- Major Issues -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Major Issues Found</h2>
                <textarea name="major_issues" rows="4" placeholder="List any major issues found during inspection..." {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('major_issues', $inspection->major_issues ?? '') }}</textarea>
            </div>

            <!-- Minor Issues -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Minor Issues Found</h2>
                <textarea name="minor_issues" rows="4" placeholder="List any minor issues found..." {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('minor_issues', $inspection->minor_issues ?? '') }}</textarea>
            </div>

            <!-- Recommendations -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Recommendations</h2>
                <textarea name="recommendations" rows="4" placeholder="Provide recommendations for repair or maintenance..." {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('recommendations', $inspection->recommendations ?? '') }}</textarea>
            </div>

            <!-- Cost Estimates -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Cost Estimates</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Repair Cost</label>
                        <div class="flex items-center">
                            <span class="text-gray-500">$</span>
                            <input type="number" name="immediate_repairs_cost" step="0.01" placeholder="0.00" value="{{ old('immediate_repairs_cost', $inspection->immediate_repairs_cost ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Future Maintenance Cost (if known)</label>
                        <div class="flex items-center">
                            <span class="text-gray-500">$</span>
                            <input type="number" name="future_maintenance_cost" step="0.01" placeholder="0.00" value="{{ old('future_maintenance_cost', $inspection->future_maintenance_cost ?? '') }}" {{ $isReadOnly ? 'readonly' : '' }} class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Drive Notes -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Test Drive Notes</h2>
                <textarea name="test_drive_notes" rows="4" placeholder="Document any issues found during test drive..." {{ $isReadOnly ? 'readonly' : '' }} class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('test_drive_notes', $inspection->test_drive_notes ?? '') }}</textarea>
            </div>

            <!-- Photo Upload -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Upload Photos</h2>

                <!-- Existing Photos -->
                @if($inspection->photos->count())
                <div class="mb-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Previously Uploaded Photos</p>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3" id="existing-photos">
                        @foreach($inspection->photos as $photo)
                        <div class="relative group">
                            <img src="{{ $photo->url }}" alt="{{ $photo->original_filename ?? 'Inspection photo' }}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs px-1 py-0.5 rounded-b-lg truncate">
                                {{ $photo->original_filename ?? 'Photo' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Upload Area -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center" id="drop-zone">
                    <input type="file" name="photos[]" multiple accept="image/*" class="hidden" id="photo-input" {{ $isReadOnly ? 'disabled' : '' }}>
                    <label for="photo-input" class="cursor-pointer">
                        <div class="text-4xl text-gray-400 mb-2">📷</div>
                        <p class="text-gray-600">Click to upload photos or drag and drop</p>
                        <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</p>
                    </label>
                </div>

                <!-- New Photo Previews -->
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mt-4 hidden" id="photo-previews"></div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const input = document.getElementById('photo-input');
                    const previewContainer = document.getElementById('photo-previews');
                    const dropZone = document.getElementById('drop-zone');

                    input.addEventListener('change', function () {
                        showPreviews(this.files);
                    });

                    // Drag and drop
                    dropZone.addEventListener('dragover', function (e) {
                        e.preventDefault();
                        dropZone.classList.add('border-blue-500', 'bg-blue-50');
                    });
                    dropZone.addEventListener('dragleave', function () {
                        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                    });
                    dropZone.addEventListener('drop', function (e) {
                        e.preventDefault();
                        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                        input.files = e.dataTransfer.files;
                        showPreviews(e.dataTransfer.files);
                    });

                    function showPreviews(files) {
                        previewContainer.innerHTML = '';
                        if (files.length === 0) {
                            previewContainer.classList.add('hidden');
                            return;
                        }
                        previewContainer.classList.remove('hidden');
                        Array.from(files).forEach(function (file) {
                            if (!file.type.startsWith('image/')) return;
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const div = document.createElement('div');
                                div.className = 'relative';
                                div.innerHTML =
                                    '<img src="' + e.target.result + '" class="w-full h-24 object-cover rounded-lg border border-gray-200">' +
                                    '<div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs px-1 py-0.5 rounded-b-lg truncate">' +
                                    file.name +
                                    '</div>';
                                previewContainer.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });
            </script>

            @if($inspection->status === 'in_progress')
                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6 flex gap-4">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        Submit for Review
                    </button>
                    <button type="button" onclick="window.history.back()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium">
                        Cancel
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
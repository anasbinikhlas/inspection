@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Key Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Appointments -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Appointments</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['total_appointments']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <span class="text-green-600 font-medium">{{ $stats['appointments_today'] }}</span>
                    <span class="text-gray-500">today</span>
                </div>
            </div>
        </div>

        <!-- Pending Appointments -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Appointments</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['pending_appointments']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
<a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}" class="text-yellow-600 hover:text-yellow-900">View all pending</a>
                </div>
            </div>
        </div>

        <!-- Completed Inspections -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed Inspections</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ number_format($stats['completed_inspections']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <span class="text-green-600 font-medium">{{ number_format($stats['avg_inspection_score'], 1) }}%</span>
                    <span class="text-gray-500">avg score</span>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Monthly Revenue</dt>
                            <dd class="text-lg font-medium text-gray-900">${{ number_format($stats['monthly_revenue'], 2) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                    <a href="{{ route('admin.analytics') }}" class="text-purple-600 hover:text-purple-900">View analytics</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Appointments -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Today's Appointments</h3>
                @if($todayAppointments->count() > 0)
                    <div class="space-y-3">
                        @foreach($todayAppointments as $appointment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-2 h-2 bg-{{ $appointment->status_color }}-500 rounded-full"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $appointment->appointment_time->format('H:i') }} - {{ $appointment->customer->full_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment->vehicle_full_name }} • {{ $appointment->location->name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800 capitalize">
                                        {{ $appointment->status }}
                                    </span>
                                    @if($appointment->inspector)
                                        <span class="text-xs text-gray-500">{{ $appointment->inspector->first_name }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No appointments scheduled for today</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
    View all appointments →
</a>
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Upcoming Appointments</h3>
                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-3">
                        @foreach($upcomingAppointments->take(5) as $appointment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="text-center">
                                            <div class="text-xs font-medium text-gray-900">{{ $appointment->appointment_date->format('M') }}</div>
                                            <div class="text-sm font-bold text-gray-900">{{ $appointment->appointment_date->format('d') }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $appointment->appointment_time->format('H:i') }} - {{ $appointment->customer->full_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment->vehicle_full_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800 capitalize">
                                        {{ $appointment->status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No upcoming appointments</p>
                @endif
                <div class="mt-4">
<a href="{{ route('admin.appointments.index', ['filter' => 'upcoming']) }}" class="text-sm text-blue-600 hover:text-blue-900">View all upcoming →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Trends Chart -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Monthly Trends</h3>
                <div style="height: 300px;">
                    <canvas id="monthlyTrendsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Inspector Performance -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Inspector Performance (This Month)</h3>
                @if($inspectorPerformance->count() > 0)
                    <div class="space-y-4">
                        @foreach($inspectorPerformance->take(5) as $inspector)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $inspector['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $inspector['inspections_count'] }} inspections</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ number_format($inspector['avg_score'], 1) }}%</p>
                                    <p class="text-xs text-gray-500">${{ number_format($inspector['revenue']) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No performance data available</p>
                @endif
                <div class="mt-4">
<a href="{{ route('admin.inspectors.index') }}" class="text-sm text-blue-600 hover:text-blue-900">View all inspectors →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Appointments</h3>
            @if($recentAppointments->count() > 0)
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentAppointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $appointment->customer->full_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $appointment->customer->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $appointment->vehicle_full_name }}</div>
                                        <div class="text-sm text-gray-500">{{ ucfirst($appointment->vehicle_type) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $appointment->appointment_time->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $appointment->location->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800 capitalize">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $appointment->formatted_price }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No recent appointments</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Monthly Trends Chart
const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
const monthlyTrendsChart = new Chart(monthlyTrendsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyTrends->pluck('month')->map(function($month) { return date('M', mktime(0, 0, 0, $month, 1)); })) !!},
        datasets: [{
            label: 'Appointments',
            data: {!! json_encode($monthlyTrends->pluck('count')) !!},
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4
        }, {
            label: 'Revenue ($)',
            data: {!! json_encode($monthlyTrends->pluck('revenue')) !!},
            borderColor: 'rgb(16, 185, 129)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false,
                },
            }
        }
    }
});
</script>
@endpush
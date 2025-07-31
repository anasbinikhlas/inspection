<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Inspector;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get key statistics
        $stats = [
            'total_appointments' => Appointment::count(),
            'appointments_today' => Appointment::today()->count(),
            'pending_appointments' => Appointment::byStatus('pending')->count(),
            'completed_inspections' => Inspection::where('status', 'completed')->count(),
            'active_customers' => Customer::active()->count(),
            'active_inspectors' => Inspector::active()->count(),
            'monthly_revenue' => Appointment::whereMonth('created_at', now()->month)
                                           ->where('status', 'completed')
                                           ->sum('price'),
            'avg_inspection_score' => Inspection::avg('overall_score')
        ];

        // Recent appointments
        $recentAppointments = Appointment::with(['customer', 'location', 'inspector'])
                                        ->orderBy('created_at', 'desc')
                                        ->limit(10)
                                        ->get();

        // Today's appointments
        $todayAppointments = Appointment::with(['customer', 'location', 'inspector'])
                                       ->today()
                                       ->orderBy('appointment_time')
                                       ->get();

        // Upcoming appointments (next 7 days)
        $upcomingAppointments = Appointment::with(['customer', 'location', 'inspector'])
                                          ->whereBetween('appointment_date', [
                                              Carbon::tomorrow(),
                                              Carbon::today()->addDays(7)
                                          ])
                                          ->orderBy('appointment_date')
                                          ->orderBy('appointment_time')
                                          ->get();

        // Monthly appointment trends
        $monthlyTrends = Appointment::select(
                            DB::raw('MONTH(appointment_date) as month'),
                            DB::raw('COUNT(*) as count'),
                            DB::raw('SUM(price) as revenue')
                        )
                        ->whereYear('appointment_date', now()->year)
                        ->groupBy(DB::raw('MONTH(appointment_date)'))
                        ->orderBy('month')
                        ->get();

        // Inspector performance
        $inspectorPerformance = Inspector::with(['inspections' => function($query) {
                                    $query->whereMonth('completed_at', now()->month);
                                }])
                                ->active()
                                ->get()
                                ->map(function($inspector) {
                                    return [
                                        'name' => $inspector->full_name,
                                        'inspections_count' => $inspector->inspections->count(),
                                        'avg_score' => $inspector->inspections->avg('overall_score') ?? 0,
                                        'revenue' => $inspector->appointments()
                                                              ->where('status', 'completed')
                                                              ->whereMonth('completed_at', now()->month)
                                                              ->sum('price')
                                    ];
                                });

        return view('admin.dashboard.index', compact(
            'stats',
            'recentAppointments',
            'todayAppointments',
            'upcomingAppointments',
            'monthlyTrends',
            'inspectorPerformance'
        ));
    }

    public function appointments()
    {
        $appointments = Appointment::with(['customer', 'location', 'inspector', 'inspection'])
                                  ->orderBy('appointment_date', 'desc')
                                  ->orderBy('appointment_time', 'desc')
                                  ->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function customers()
    {
        $customers = Customer::withCount('appointments')
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function inspectors()
    {
        $inspectors = Inspector::withCount(['appointments', 'inspections'])
                              ->orderBy('created_at', 'desc')
                              ->paginate(20);

        return view('admin.inspectors.index', compact('inspectors'));
    }

    public function analytics()
    {
        // Revenue analytics
        $revenueData = [
            'daily' => $this->getDailyRevenue(),
            'monthly' => $this->getMonthlyRevenue(),
            'by_package' => $this->getRevenueByPackage(),
            'by_location' => $this->getRevenueByLocation()
        ];

        // Inspection analytics
        $inspectionData = [
            'completion_rate' => $this->getCompletionRate(),
            'avg_scores' => $this->getAverageScores(),
            'common_issues' => $this->getCommonIssues(),
            'inspector_performance' => $this->getInspectorPerformance()
        ];

        // Customer analytics
        $customerData = [
            'new_customers' => $this->getNewCustomersData(),
            'repeat_customers' => $this->getRepeatCustomersData(),
            'customer_satisfaction' => $this->getCustomerSatisfactionData()
        ];

        return view('admin.analytics.index', compact(
            'revenueData',
            'inspectionData',
            'customerData'
        ));
    }

    private function getDailyRevenue()
    {
        return Appointment::select(
                    DB::raw('DATE(appointment_date) as date'),
                    DB::raw('SUM(price) as revenue'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('status', 'completed')
                ->whereBetween('appointment_date', [Carbon::now()->subDays(30), Carbon::now()])
                ->groupBy(DB::raw('DATE(appointment_date)'))
                ->orderBy('date')
                ->get();
    }

    private function getMonthlyRevenue()
    {
        return Appointment::select(
                    DB::raw('YEAR(appointment_date) as year'),
                    DB::raw('MONTH(appointment_date) as month'),
                    DB::raw('SUM(price) as revenue'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('status', 'completed')
                ->whereBetween('appointment_date', [Carbon::now()->subMonths(12), Carbon::now()])
                ->groupBy(DB::raw('YEAR(appointment_date)'), DB::raw('MONTH(appointment_date)'))
                ->orderBy('year')
                ->orderBy('month')
                ->get();
    }

    private function getRevenueByPackage()
    {
        return Appointment::select('package_type', DB::raw('SUM(price) as revenue'), DB::raw('COUNT(*) as count'))
                         ->where('status', 'completed')
                         ->groupBy('package_type')
                         ->get();
    }

    private function getRevenueByLocation()
    {
        return Appointment::join('locations', 'appointments.location_id', '=', 'locations.id')
                         ->select('locations.name', DB::raw('SUM(appointments.price) as revenue'), DB::raw('COUNT(*) as count'))
                         ->where('appointments.status', 'completed')
                         ->groupBy('locations.id', 'locations.name')
                         ->get();
    }

    private function getCompletionRate()
    {
        $total = Appointment::count();
        $completed = Appointment::where('status', 'completed')->count();
        
        return $total > 0 ? ($completed / $total) * 100 : 0;
    }

    private function getAverageScores()
    {
        return [
            'overall' => Inspection::avg('overall_score'),
            'engine' => Inspection::avg('engine_transmission_score'),
            'brakes' => Inspection::avg('brakes_score'),
            'suspension' => Inspection::avg('suspension_steering_score'),
            'electrical' => Inspection::avg('electrical_score'),
            'exterior' => Inspection::avg('exterior_body_score')
        ];
    }

    private function getCommonIssues()
    {
        return DB::table('inspection_items')
                ->select('item_name', DB::raw('COUNT(*) as frequency'))
                ->whereIn('condition', ['poor', 'failed'])
                ->groupBy('item_name')
                ->orderBy('frequency', 'desc')
                ->limit(10)
                ->get();
    }

    private function getInspectorPerformance()
    {
        return Inspector::with(['inspections' => function($query) {
                    $query->whereMonth('completed_at', now()->month);
                }])
                ->get()
                ->map(function($inspector) {
                    return [
                        'name' => $inspector->full_name,
                        'inspections_count' => $inspector->inspections->count(),
                        'avg_score' => round($inspector->inspections->avg('overall_score') ?? 0, 2),
                        'avg_duration' => $inspector->inspections->avg(
                            DB::raw('TIMESTAMPDIFF(MINUTE, started_at, completed_at)')
                        ) ?? 0
                    ];
                });
    }

    private function getNewCustomersData()
    {
        return Customer::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();
    }

    private function getRepeatCustomersData()
    {
        return Customer::whereHas('appointments', function($query) {
                    $query->havingRaw('COUNT(*) > 1');
                })
                ->count();
    }

    private function getCustomerSatisfactionData()
    {
        // This would typically come from a separate ratings/feedback table
        // For now, we'll estimate based on inspection scores
        return Inspection::select(
                    'overall_condition',
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('overall_condition')
                ->get();
    }
}
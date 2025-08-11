<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $appointments = Appointment::with(['customer', 'location', 'inspector'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('appointment_date')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments', 'status'));
    }
}

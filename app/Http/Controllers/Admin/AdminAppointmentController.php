<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    public function index()
    {
        // You can load appointments later, for now just show the view
        return view('admin.appointments.index');
    }
}

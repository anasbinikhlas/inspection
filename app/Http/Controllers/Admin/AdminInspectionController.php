<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminInspectionController extends Controller
{
    public function index()
    {
        // Later, you can pass real inspection data
        return view('admin.inspections.index');
    }
}

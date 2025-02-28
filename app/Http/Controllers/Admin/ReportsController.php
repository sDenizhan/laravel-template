<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function applications()
    {
        return view('reports.applications');
    }

    public function coordinators()
    {
        return view('reports.coordinators');
    }

    public function finance()
    {
        return view('reports.finance');
    }
} 
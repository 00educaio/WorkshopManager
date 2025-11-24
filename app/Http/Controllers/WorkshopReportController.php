<?php

namespace App\Http\Controllers;

use App\Models\WorkshopReport;
use Illuminate\Http\Request;

class WorkshopReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = WorkshopReport::all();
        return view('reports.index', compact('reports'));
    }
}

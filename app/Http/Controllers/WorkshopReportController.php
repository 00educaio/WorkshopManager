<?php

namespace App\Http\Controllers;

use App\Models\WorkshopReport;
use Illuminate\Http\Request;

class WorkshopReportController extends Controller
{
    public function index()
    {
        $reports = WorkshopReport::all();
        
        return view('reports.index', compact('reports'));
    }

    public function show(WorkshopReport $report)
    {
        
        return view('reports.show', compact('report'));
    }
}

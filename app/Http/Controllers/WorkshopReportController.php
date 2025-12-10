<?php

namespace App\Http\Controllers;

use App\Models\WorkshopReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkshopReportController extends Controller
{
    public function index()
    {
        $reports = WorkshopReport::orderBy('report_date', 'desc')->get();

        $reports->each(function ($report) {
            $report->report_date = Carbon::parse($report->report_date)->format('d/m/Y');
        });
        
        return view('reports.index', compact('reports'));
    }

    public function show(WorkshopReport $report)
    {
        $report->report_date = Carbon::parse($report->report_date)->format('d/m/Y');

        $report->schoolClasses = $report->schoolClasses->sortBy('time');
        
        return view('reports.show', compact('report'));
    }
}

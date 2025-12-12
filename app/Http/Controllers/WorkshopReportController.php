<?php

namespace App\Http\Controllers;

use App\Models\WorkshopReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopReportController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkshopReport::query();
        
        if (Auth::user()->role == 'instructor') {
            $query->where('instructor_id', Auth::id());
        }

        // 1. Filtro por Data de Início
        if ($request->filled('start_date')) {
            $query->whereDate('report_date', '>=', $request->start_date);
        }

        // 2. Filtro por Data de Término
        if ($request->filled('end_date')) {
            $query->whereDate('report_date', '<=', $request->end_date);
        }

        // 3. Filtro por Nome do Oficineiro (Instrutor)
        if ($request->filled('instructor')) {
            $search = $request->instructor;

            // Busca pelo nome do instrutor
            $query->whereHas('instructor', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
            
        }
        $reports = $query->orderBy('report_date', 'desc')
                         ->paginate(10)
                         ->withQueryString();

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

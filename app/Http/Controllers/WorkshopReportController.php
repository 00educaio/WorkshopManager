<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportStoreRequest;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\WorkshopReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function create()
    {
        $instructors = User::where('role', 'instructor')->get();
        $schoolClasses = SchoolClass::all();
        return view('reports.create', compact('instructors', 'schoolClasses'));
    }

    public function store(ReportStoreRequest $request)
    {
        try {
            // O DB::transaction executa o bloco. Se der erro, desfaz tudo. Se der certo, retorna o resultado.
            $report = DB::transaction(function () use ($request) {
                
                $reportData = $request->safe()->except(['workshops']);
                $workshopsData = $request->safe()->only(['workshops'])['workshops'];

                $report = WorkshopReport::create($reportData);

                $report->schoolClasses()->createMany($workshopsData);

                return $report;
            });

            return redirect()->route('reports.show', $report->id)
                            ->with('status', [
                                'type' => 'success',
                                'message' => 'Relatório criado com sucesso!'
                            ]);

        } catch (\Exception $e) {        
            return back()->withErrors(['error' => 'Erro ao criar o relatório: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    public function edit(WorkshopReport $report)
    {
        $instructors = User::where('role', 'instructor')->get();
        $schoolClasses = SchoolClass::all();
        return view('reports.edit', compact('report', 'instructors', 'schoolClasses'));
    }

    public function update(ReportStoreRequest $request, WorkshopReport $report)
    {
        $report->update($request->safe()->except(['workshops']));
        $report->schoolClasses()->delete();
        $report->schoolClasses()->createMany($request->safe()->only(['workshops'])['workshops']);
        return redirect()->route('reports.show', $report->id)
                        ->with('status', [
                            'type' => 'success',
                            'message' => 'Relatório atualizado com sucesso!'
                        ]);
    }

    public function destroy(WorkshopReport $report)
    {
        $report->delete();
        return redirect()->route('reports.index')
                        ->with('status', [
                            'type' => 'deleted',
                            'message' => 'Relatório excluído com sucesso!'
                        ]);
    }

}

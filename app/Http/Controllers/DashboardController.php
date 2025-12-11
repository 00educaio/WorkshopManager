<?php

namespace App\Http\Controllers;

use App\Models\WorkshopReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $sixMonthsAgo = $now->copy()->subMonths(5)->startOfMonth();

        return view('dashboard', [
            'workshopsByMonth'    => $this->getWorkshopsByMonth($sixMonthsAgo),
            'topInstructors'      => $this->getTopInstructors(),
            'feedbackData'        => $this->getFeedbackDistribution(),
            'extraActivitiesData' => $this->getExtraActivitiesData(),
            'materialsData'       => $this->getMaterialsData(),
            'summaryCards'        => $this->getSummaryCards($startOfMonth),
        ]);
    }

    /**
     * Retorna as sintaxes SQL corretas dependendo do banco (SQLite ou MySQL)
     */
    private function getSqlSyntax()
    {
        $driver = DB::connection()->getDriverName();
        $isSqlite = $driver === 'sqlite';

        return [
            // SQLite usa strftime, MySQL usa DATE_FORMAT
            'month_format' => $isSqlite 
                ? 'strftime("%Y-%m", report_date)' 
                : 'DATE_FORMAT(report_date, "%Y-%m")',
            
            // SQLite não aceita COUNT(DISTINCT col1, col2), precisa concatenar
            'count_distinct_workshops' => $isSqlite 
                ? 'COUNT(DISTINCT classes.workshop_report_id || "-" || classes.time)' 
                : 'COUNT(DISTINCT classes.workshop_report_id, classes.time)',
        ];
    }

    private function getWorkshopsByMonth(Carbon $startDate): array
    {
        $sql = $this->getSqlSyntax();

        $reports = WorkshopReport::query()
            ->selectRaw("{$sql['month_format']} as month_key")
            ->selectRaw('COUNT(*) as total_reports')
            ->leftJoin('workshop_report_school_classes as classes', 'workshop_reports.id', '=', 'classes.workshop_report_id')
            ->selectRaw("{$sql['count_distinct_workshops']} as total_workshops")
            ->where('report_date', '>=', $startDate)
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->get()
            ->keyBy('month_key');

        $result = ['labels' => [], 'reports' => [], 'workshops' => []];
        $current = $startDate->copy();

        for ($i = 0; $i < 6; $i++) {
            $key = $current->format('Y-m');
            $monthData = $reports->get($key);

            $result['labels'][] = $current->isoFormat('MMM/YY');
            $result['reports'][] = $monthData ? $monthData->total_reports : 0;
            $result['workshops'][] = $monthData ? $monthData->total_workshops : 0;

            $current->addMonth();
        }

        return $result;
    }

    private function getTopInstructors()
    {
        $sql = $this->getSqlSyntax();

        return WorkshopReport::query()
            ->select('instructor_id')
            ->selectRaw('COUNT(*) as total_reports')
            ->selectRaw("{$sql['count_distinct_workshops']} as total_workshops")
            ->join('users', 'users.id', '=', 'workshop_reports.instructor_id')
            ->leftJoin('workshop_report_school_classes as classes', 'workshop_reports.id', '=', 'classes.workshop_report_id')
            ->with('instructor:id,name')
            ->groupBy('instructor_id')
            ->orderByDesc('total_reports')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'name' => $item->instructor->name ?? 'Desconhecido',
                    'total_reports' => $item->total_reports,
                    'total_workshops' => $item->total_workshops,
                ];
            });
    }

    private function getFeedbackDistribution(): array
    {
        // Mantido igual (já é compatível com ambos)
        $withFeedback = WorkshopReport::whereNotNull('feedback')->where('feedback', '!=', '')->count();
        $total = WorkshopReport::count();

        return [
            'labels' => ['Com feedback', 'Sem feedback'],
            'data'   => [$withFeedback, $total - $withFeedback],
            'colors' => ['#36A2EB', '#FF6384']
        ];
    }

    private function getExtraActivitiesData(): array
    {
        // Mantido igual
        $withExtras = WorkshopReport::where('extra_activities', 1)->count();
        $total = WorkshopReport::count();
        
        return [
            'labels' => ['Com atividades extras', 'Sem atividades extras'],
            'data'   => [$withExtras, $total - $withExtras],
            'colors' => ['#4BC0C0', '#FF9F40']
        ];
    }

    private function getMaterialsData(): array
    {
        // Mantido igual
        $withMaterials = WorkshopReport::where('materials_provided', 1)->count();
        $total = WorkshopReport::count();

        return [
            'labels' => ['Materiais fornecidos', 'Sem materiais'],
            'data'   => [$withMaterials, $total - $withMaterials],
            'colors' => ['#9966FF', '#FFCD56']
        ];
    }

    private function getSummaryCards(Carbon $startOfMonth): array
    {
        // Correção para SQLite na contagem distinta de múltiplas colunas
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite: Concatena colunas para distinct
            $totalWorkshops = DB::table('workshop_report_school_classes')
                ->selectRaw('COUNT(DISTINCT workshop_report_id || "-" || time) as total')
                ->value('total');
        } else {
            // MySQL
            $totalWorkshops = DB::table('workshop_report_school_classes')
                ->distinct(DB::raw('workshop_report_id, time'))
                ->count();
        }

        return [
            'total_reports' => WorkshopReport::count(),
            'total_instructors' => WorkshopReport::distinct('instructor_id')->count('instructor_id'),
            'reports_this_month' => WorkshopReport::whereYear('report_date', $startOfMonth->year)
                ->whereMonth('report_date', $startOfMonth->month)
                ->count(),
            'reports_with_feedback' => WorkshopReport::whereNotNull('feedback')
                ->where('feedback', '!=', '')
                ->count(),
            'total_workshops' => $totalWorkshops,
            'reports_with_extras' => WorkshopReport::where('extra_activities', 1)->count(),
        ];
    }
}
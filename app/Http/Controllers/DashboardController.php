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
     * Retorna as sintaxes SQL corretas dependendo do banco (Postgres, SQLite ou MySQL)
     */
    private function getSqlSyntax()
    {
        $driver = DB::connection()->getDriverName();

        // Configuração padrão (MySQL/MariaDB)
        $syntax = [
            'month_format' => 'DATE_FORMAT(report_date, "%Y-%m")',
            'count_distinct_workshops' => 'COUNT(DISTINCT classes.workshop_report_id, classes.time)',
        ];

        if ($driver === 'pgsql') {
            $syntax = [
                // Postgres usa TO_CHAR
                'month_format' => "TO_CHAR(report_date, 'YYYY-MM')",
                // Postgres suporta contagem de tuplas com parênteses extras: COUNT(DISTINCT (col1, col2))
                // Ou podemos concatenar para garantir compatibilidade se houver nulos de forma estranha,
                // mas a tupla é o jeito "Postgres".
                'count_distinct_workshops' => 'COUNT(DISTINCT (classes.workshop_report_id, classes.time))',
            ];
        } elseif ($driver === 'sqlite') {
            $syntax = [
                'month_format' => 'strftime("%Y-%m", report_date)',
                'count_distinct_workshops' => 'COUNT(DISTINCT classes.workshop_report_id || "-" || classes.time)',
            ];
        }

        return $syntax;
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
            ->groupBy('month_key') // Postgres permite agrupar pelo alias da seleção na maioria das versões recentes
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

        // Nota: Postgres é estrito no GROUP BY. Todas as colunas no SELECT que não são agregadas
        // devem estar no GROUP BY. O Laravel lida bem com isso, mas se tiver erro de "column must appear in GROUP BY",
        // teríamos que adicionar users.name no groupBy ou usar uma função de agregação.
        // Abaixo, estamos agrupando por instructor_id e pegando o nome via relacionamento 'with', o que evita esse erro no SQL principal.

        return WorkshopReport::query()
            ->select('instructor_id')
            ->selectRaw('COUNT(*) as total_reports')
            ->selectRaw("{$sql['count_distinct_workshops']} as total_workshops")
            ->leftJoin('workshop_report_school_classes as classes', 'workshop_reports.id', '=', 'classes.workshop_report_id')
            ->with('instructor:id,name') // Carrega o nome separadamente para evitar problemas de Group By no SQL principal
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
        $driver = DB::connection()->getDriverName();
        
        // Lógica para contar workshops únicos (ID do relatório + Horário da turma)
        if ($driver === 'sqlite') {
            $totalWorkshops = DB::table('workshop_report_school_classes')
                ->selectRaw('COUNT(DISTINCT workshop_report_id || "-" || time) as total')
                ->value('total');
        } else {
            // PostgreSQL e MySQL funcionam bem com esta sintaxe do Laravel Builder.
            // O Laravel converte isso internamente para "select count(*) from (select distinct ...)"
            // o que é válido no Postgres.
            $totalWorkshops = DB::table('workshop_report_school_classes')
                ->distinct(DB::raw('workshop_report_id, time'))
                ->count();
        }

        return [
            'total_reports' => WorkshopReport::count(),
            // Distinct simples funciona igual em todos
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
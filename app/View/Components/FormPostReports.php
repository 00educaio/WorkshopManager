<?php

namespace App\View\Components;

use App\Models\WorkshopReport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;
class FormPostReports extends Component
{
    /**
     * Create a new component instance.
     */
    public string $href;
    public ?WorkshopReport $report;
    public Collection $instructors;
    public Collection $schoolClasses;
    public function __construct( string $href, ?WorkshopReport $report, Collection $instructors, Collection $schoolClasses)
    {
        $this->href = $href;
        $this->report = $report;
        $this->instructors = $instructors;
        $this->schoolClasses = $schoolClasses;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-post-reports');
    }
}

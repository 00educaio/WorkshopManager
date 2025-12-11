<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainView extends Component
{
    /**
     * Create a new component instance.
     */

    public $sectionTitle;
    public function __construct($sectionTitle)
    {
        $this->sectionTitle = $sectionTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.main-view');
    }
}

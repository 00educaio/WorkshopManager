<?php

namespace App\View\Components;

use App\Models\SchoolClass;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class FormPostClasses extends Component
{
    /**
     * Create a new component instance.
     */
    public string $href;
    public ?SchoolClass $class;
    public Collection $origins;
    public function __construct( string $href, SchoolClass $class, Collection $origins)
    {
        $this->href = $href;
        $this->class = $class;
        $this->origins = $origins;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-post-classes');
    }
}

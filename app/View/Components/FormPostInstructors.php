<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormPostInstructors extends Component
{
    /**
     * Create a new component instance.
     */
    public $href;
    public ?User $instructor;
    public function __construct(string $href, User $instructor)
    {
        $this->href = $href;
        $this->instructor = $instructor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-post-instructors');
    }
}

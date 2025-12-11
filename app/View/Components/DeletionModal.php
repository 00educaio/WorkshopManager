<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeletionModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $editHref;
    public $deleteHref;
    public $backHref;
    public function __construct($backHref, $editHref, $deleteHref)
    {
        $this->editHref = $editHref;
        $this->deleteHref = $deleteHref;
        $this->backHref = $backHref;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.deletion-modal');
    }
}

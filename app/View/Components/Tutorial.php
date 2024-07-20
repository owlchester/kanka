<?php

namespace App\View\Components;

use App\Facades\UserCache;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tutorial extends Component
{
    public string $code;
    public ?string $doc;
    public string $id;
    public ?string $type;

    /**
     * Create a new component instance.
     */
    public function __construct(string $code, ?string $doc = null, ?string $type = null)
    {
        $this->code = $code;
        $this->doc = $doc;
        $this->id = uniqid($code . '-');
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!auth()->check()) {
            return '';
        }
        if (UserCache::dismissedTutorial($this->code)) {
            return '';
        }
        return view('components.tutorial');
    }
}

<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Exception;

class Since extends Component
{
    private string $formattedDate;

    public string $dateFormat = 'LL';

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Carbon $date,
        public bool $withTime = true
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (empty($this->date)) {
            return '';
        }
        $this->loadUserFormat();
        try {
            $this->formattedDate = $this->date->isoFormat($this->dateFormat . ($this->withTime ? ' HH:mm:ss' : null));
        } catch (Exception $e) {
            $this->formattedDate = $this->date->isoFormat($this->withTime ? 'LL HH:mm:ss' : 'LL');
        }

        return view('components.since')
            ->with('formatted', $this->formattedDate);
    }

    public function elapsed(): string
    {
        if ($this->date->diffInMonths() <= 2) {
            return $this->date->diffForHumans();
        }
        return $this->date->isoFormat($this->dateFormat);
    }

    /**
     * Load the user's format if logged in
     */
    private function loadUserFormat(): void
    {
        // Get the user's date format if they have a custom one
        if (auth()->guest() || empty(auth()->user()->dateformat)) {
            return;
        }
        $this->dateFormat = mb_strtoupper(auth()->user()->dateformat);
        $this->dateFormat = Str::replace(['M', 'D'], ['MM', 'DD'], $this->dateFormat);
    }
}

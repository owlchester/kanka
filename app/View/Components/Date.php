<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Exception;

class Date extends Component
{
    /**
     * Default format is MMMM d, Y
     */
    private string $format = 'LL';

    private string $formattedDate;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $date,
        public bool $string = false
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
            $original = new Carbon($this->date);
            $this->formattedDate = $original->isoFormat($this->format);
        } catch (Exception $e) {
           $this->formattedDate = $this->date;
        }

        if ($this->string) {
            return $this->formattedDate;
        }
        return view('components.date')
            ->with('formatted', $this->formattedDate);
    }

    public function format(): string
    {
        return $this->format;
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
        $this->format = mb_strtoupper(auth()->user()->dateformat);
        $this->format = Str::replace(['M', 'D'], ['MM', 'DD'], $this->format);
    }
}

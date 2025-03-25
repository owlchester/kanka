<?php

namespace App\View\Components\Tags;

use App\Models\Campaign;
use App\Models\Tag;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bubble extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Tag $tag,
        public Campaign $campaign,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tags.bubble')
            ->with('css', $this->css());
    }

    protected function css(): string
    {
        $classes = [
            'badge',
        ];
        if ($this->tag->hasColour()) {
            $classes[] = $this->tag->colourClass();
        } else {
            $classes[] = 'color-tag';
        }

        return implode(' ', $classes);
    }
}

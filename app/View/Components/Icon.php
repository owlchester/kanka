<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public string $class;
    public ?string $title;
    public ?string $tooltip;
    public ?string $link;
    public ?string $size;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $class,
        string $tooltip = null,
        string $title = null,
        string $link = null,
        string $size = null,
    )
    {
        $this->class = $this->map($class);
        $this->tooltip = $tooltip;
        $this->title = $title;
        $this->link = $link;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.icon');
    }

    /**
     * Map icon shortcuts into their fontawesome or other elements
     * @param string $class
     * @return string
     */
    protected function map(string $class): string
    {
        return match ($class) {
            'map' => 'fa-regular fa-map',
            'trash' => 'fa-regular fa-trash-can',
            'plus' => 'fa-solid fa-plus',
            'question' => 'fa-solid fa-question-circle',
            'save' => 'fa-solid fa-save',
            'pencil' => 'fa-solid fa-pencil',
            'cog' => 'fa-solid fa-cog',
            'edit' => 'fa-solid fa-edit',
            'premium' => 'fa-solid fa-rocket',
            'filter' => 'fa-solid fa-filter',
            default => $class,
        };
    }
}

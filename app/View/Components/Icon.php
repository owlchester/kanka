<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $class = null,
        public bool $tooltip = false,
        public ?string $title = null,
        public ?string $link = null,
        public ?string $size = null,
        public ?string $label = null,
        public ?string $show = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->class = $this->map($this->class);

        return view('components.icon');
    }

    /**
     * Map icon shortcuts into their fontawesome or other elements
     */
    protected function map(string $class): string
    {
        return match ($class) {
            'map' => 'fa-regular fa-map',
            'check' => 'fa-regular fa-check',
            'trash' => 'fa-regular fa-trash-can',
            'plus' => 'fa-regular fa-plus',
            'question' => 'fa-regular fa-question-circle',
            'save' => 'fa-regular fa-save',
            'pencil' => 'fa-regular fa-pencil',
            'cog' => 'fa-regular fa-cog',
            'copy' => 'fa-regular fa-copy',
            'edit' => 'fa-regular fa-edit',
            'premium' => 'fa-regular fa-gem',
            'lock' => 'fa-regular fa-lock',
            'filter' => 'fa-regular fa-filter',
            'load' => 'fa-solid fa-spinner fa-spin',
            'arrow' => 'fa-regular fa-arrow-right',
            'permissions' => 'fa-regular fa-user-shield',
            'attributes' => 'fa-regular fa-rectangle-list',
            'link' => 'fa-regular fa-external-link',
            'sort' => 'fa-regular fa-grip-vertical',
            default => $class,
        };
    }
}

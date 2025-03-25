<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $class = null,
        public ?string $entity = null,
        public bool $tooltip = false,
        public ?string $title = null,
        public ?string $link = null,
        public ?string $size = null,
        public ?string $label = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (empty($this->class) && ! empty($this->entity)) {
            $this->class = $this->mapEntity($this->entity);
        } elseif (! empty($this->class)) {
            $this->class = $this->map($this->class);
        }

        return view('components.icon');
    }

    /**
     * Map icon shortcuts into their fontawesome or other elements
     */
    protected function map(string $class): string
    {
        return match ($class) {
            'map' => 'fa-regular fa-map',
            'check' => 'fa-solid fa-check',
            'trash' => 'fa-regular fa-trash-can',
            'plus' => 'fa-solid fa-plus',
            'question' => 'fa-solid fa-question-circle',
            'save' => 'fa-regular fa-save',
            'pencil' => 'fa-solid fa-pencil',
            'cog' => 'fa-regular fa-cog',
            'copy' => 'fa-regular fa-copy',
            'edit' => 'fa-regular fa-edit',
            'premium' => 'fa-regular fa-gem',
            'lock' => 'fa-regular fa-lock',
            'filter' => 'fa-regular fa-filter',
            'load' => 'fa-solid fa-spinner fa-spin',
            default => $class,
        };
    }

    /**
     * Get the icon class based on the entity type
     */
    protected function mapEntity(string $entity): string
    {
        $class = config('entities.icons.' . $entity);
        if (config('fontawesome.kit')) {
            return $class;
        }

        return Str::replace('fa-duotone', 'fa-solid', $class);
    }
}

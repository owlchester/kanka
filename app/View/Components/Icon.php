<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
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
        string $class = null,
        string $entity = null,
        string $tooltip = null,
        string $title = null,
        string $link = null,
        string $size = null,
    ) {
        if (empty($class) && !empty($entity)) {
            $this->class = $this->mapEntity($entity);
        } elseif (!empty($class)) {
            $this->class = $this->map($class);
        } else {
            $this->class = '';
        }
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
     */
    protected function map(string $class): string
    {
        return match ($class) {
            'map' => 'fa-regular fa-map',
            'check' => 'fa-solid fa-check',
            'trash' => 'fa-regular fa-trash-can',
            'plus' => 'fa-solid fa-plus',
            'question' => 'fa-solid fa-question-circle',
            'save' => 'fa-solid fa-save',
            'pencil' => 'fa-solid fa-pencil',
            'cog' => 'fa-solid fa-cog',
            'copy' => 'fa-solid fa-copy',
            'edit' => 'fa-solid fa-edit',
            'premium' => 'fa-solid fa-rocket',
            'filter' => 'fa-solid fa-filter',
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

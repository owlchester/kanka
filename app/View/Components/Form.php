<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string|array $action,
        public array $config = [],
        public string $method = 'POST',
        public bool $files = false,
        public bool $shortcut = true,
        public bool $unsaved = false,
        public bool $direct = false,
        public string $id = '',
        public string $class = '',
        public array $extra = [],
    ) {
        // Guarantee uppercase method for the tests in the blade file
        $this->method = mb_strtoupper($method);
        foreach ($config as $k => $v) {
            if (! property_exists($this, $k)) {
                continue;
            }
            $this->$k = $v;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }

    public function extra(): ?string
    {
        if (empty($this->extra)) {
            return null;
        }
        $extra = [];
        foreach ($this->extra as $k => $v) {
            $extra[] = $k . '="' . $v . '"';
        }

        return implode(' ', $extra);
    }

    public function action(): string
    {
        if (! is_array($this->action)) {
            return route($this->action);
        }
        $parameters = array_slice($this->action, 1);

        if (array_keys($this->action) === [0, 1]) {
            $parameters = head($parameters);
        }

        return route($this->action[0], $parameters);
    }
}

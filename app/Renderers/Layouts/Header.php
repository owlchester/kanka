<?php

namespace App\Renderers\Layouts;

use Illuminate\Support\Arr;

class Header
{
    /** @var array|string */
    protected $data;

    protected $orderField;
    protected $orderDir;

    public function __construct(array|string $data)
    {
        $this->data = $data;
    }

    public function __toString(): string
    {
        if (empty($this->data)) {
            return '';
        }
        if (empty($this->data['label'])) {
            return '<i>no label</i>';
        }

        if (!$this->sortable()) {
            return __($this->data['label']);
        }

        // Prepare some data
        $this->orderField = request()->get('k');
        $this->orderDir = request()->get('o');

        // We have some HTML going on, let blade render it
        return view('layouts.datagrid._head')
            ->with('head', $this);

    }

    public function css(): string|null
    {
        if (empty($this->data['class'])) {
            return null;
        }

        return $this->data['class'];
    }

    public function bulk(): bool
    {
        return !is_array($this->data) && $this->data === 'bulk';
    }

    /**
     * @return bool
     */
    public function sortable(): bool
    {
        return !empty($this->data['key']) && !empty(request()->route());
    }

    /**
     * @return string|null
     */
    public function icon(): null|string
    {
        if ($this->orderField != $this->data['key']) {
            return '';
        }

        if ($this->orderDir == 'asc') {
            return '<i class="fa-solid fa-arrow-up-a-z"></i> ';
        }
        return '<i class="fa-solid fa-arrow-down-z-a"></i> ';
    }

    /**
     * @return string
     */
    public function route(): string
    {
        $route = request()->route()->getName();
        $options = [
            'k' => $this->data['key'],
            'o' => 'asc'
        ];
        if ($this->orderField == $this->data['key']) {
            // Already desc? we want to reset
            if ($this->orderDir == 'desc') {
                $options = [];
            } else {
                $options['o'] = 'desc';
            }
        }

        return route($route, $options);
    }

    /**
     * @return string
     */
    public function label(): string
    {
        return $this->data['label'];
    }
}

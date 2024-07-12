<?php

namespace App\Renderers\Layouts;

use App\Facades\Datagrid;
use App\Renderers\Layouts\Columns\Standard;
use App\Traits\CampaignAware;
use Exception;
use Illuminate\Support\Arr;

class Header
{
    use CampaignAware;

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
            if (Arr::get($this->data, 'render') === Standard::IMAGE) {
                return '';
            }
            if (Arr::get($this->data, 'render') === Standard::TAGS) {
                return __('entities.tags');
            }

            return !isset($this->data['label']) ? '<i>no label</i>' : '';
        }

        if (!$this->sortable()) {
            return __($this->data['label']);
        }

        // Prepare some data
        $this->orderField = request()->get('k');
        $this->orderDir = request()->get('o');

        // We have some HTML going on, let blade render it
        try {
            return view('layouts.datagrid._head')
                ->with('head', $this)
                ->render();
        } catch (Exception $e) {
            throw $e;
            //return $e->getMessage();
        }
    }

    public function css(): string|null
    {
        $default = null;
        if (Arr::get($this->data, 'render') === Standard::IMAGE) {
            $default = 'avatar w-14';
        }
        if (empty($this->data['class'])) {
            return $default;
        }

        return $this->data['class'];
    }

    public function bulk(): bool
    {
        return !is_array($this->data) && $this->data === 'bulk';
    }

    /**
     */
    public function sortable(): bool
    {
        return !empty($this->data['key']) && auth()->check() && !empty(request()->route());
    }

    /**
     */
    public function icon(): null|string
    {
        if ($this->orderField != $this->data['key']) {
            return '';
        }

        if ($this->orderDir == 'asc') {
            return 'fa-solid fa-arrow-up-a-z';
        }
        return 'fa-solid fa-arrow-down-z-a';
    }

    /**
     */
    public function route(): string
    {
        $route = Datagrid::routeName();
        $options = [
            'campaign' => $this->campaign,
            'k' => $this->data['key'],
            'o' => 'asc'
        ];
        if ($this->orderField == $this->data['key']) {
            // Already desc? we want to reset
            if ($this->orderDir == 'desc') {
                $options = ['campaign' => $this->campaign];
            } else {
                $options['o'] = 'desc';
            }
        }
        $options = array_merge($options, Datagrid::routeOptions());
        if (request()->has('page')) {
            $options['page'] = (int) request()->get('page');
        }

        try {
            return route($route, $options);
        } catch (Exception $e) {
            throw $e;
            //return 'invalid';
        }
    }

    /**
     */
    public function label(): string
    {
        return $this->data['label'];
    }
}

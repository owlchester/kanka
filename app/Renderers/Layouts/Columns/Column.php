<?php

namespace App\Renderers\Layouts\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Column for the datagrid2 rendering
 */
abstract class Column
{
    /** @var Model */
    protected $model;

    /** @var array */
    protected $config;

    /**
     * @param Model $model
     * @param array $config
     */
    public function __construct(Model $model, array $config)
    {
        $this->model = $model;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }

    /**
     * @return string|null
     */
    public function css(): string|null
    {
        $default = null;
        if (Arr::get($this->config, 'render') === Standard::IMAGE) {
            $default = 'avatar';
        }
        if (empty($this->config['class'])) {
            return $default;
        }

        return (string) $this->config['class'];
    }
}

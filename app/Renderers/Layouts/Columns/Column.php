<?php

namespace App\Renderers\Layouts\Columns;

use Illuminate\Database\Eloquent\Model;

abstract class Column
{
    /** @var Model */
    protected $model;

    protected $config;

    public function __construct(Model $model, array $config)
    {
        $this->model = $model;
        $this->config = $config;
    }

    public function __toString(): string
    {
        return '';
    }

    public function css(): string|null
    {
        return null;
    }

}

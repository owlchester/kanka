<?php

namespace App\Renderers\Layouts\Columns;

use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Column for the datagrid2 rendering
 */
abstract class Column
{
    /** @var Model|MiscModel */
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
        return null;
    }
}

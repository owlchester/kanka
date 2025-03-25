<?php

namespace App\Facades;

use App\Renderers\DatagridRenderer2;
use Illuminate\Support\Facades\Facade;

/**
 * Class Datagrid
 *
 * @see DatagridRenderer2
 *
 * @mixin \App\Renderers\DatagridRenderer2
 */
class Datagrid extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DatagridRenderer2::class;
    }
}

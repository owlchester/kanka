<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Breadcrumb
 *
 * @see \App\Services\BreadcrumbService
 *
 * @mixin \App\Services\BreadcrumbService
 */
class Breadcrumb extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'breadcrumb';
    }
}

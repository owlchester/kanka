<?php

namespace App\Facades;

use App\Services\BreadcrumbService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Breadcrumb
 *
 * @see BreadcrumbService
 *
 * @mixin BreadcrumbService
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

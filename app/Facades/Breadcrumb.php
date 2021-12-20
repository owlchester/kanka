<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class Breadcrumb
 * @package App\Facades
 *
 * @see \App\Services\BreadcrumService
 * @mixin \App\Services\BreadcrumService
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
